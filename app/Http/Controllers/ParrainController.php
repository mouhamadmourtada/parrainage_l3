<?php

namespace App\Http\Controllers;

use App\Models\Parrain;
use App\Models\User;
use App\Services\MailingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ParrainController extends Controller
{
    protected $mailingService;

    public function __construct(MailingService $mailingService)
    {
        $this->mailingService = $mailingService;
    }

    public function showActivationForm()
    {
        return view('parrains.activation');
    }

    public function verifyElecteur(Request $request)
    {
        try {
            $request->validate([
                'numero_electeur' => 'required',
                'cin' => 'required',
                'nom' => 'required',
                'bureau_vote' => 'required'
            ]);

            // Vérifier si l'électeur peut être parrain
            $canBeParrain = DB::select(
                "SELECT PeutEtreParrain(?, ?, ?, ?) as result",
                [
                    $request->numero_electeur,
                    $request->cin,
                    $request->nom,
                    $request->bureau_vote
                ]
            )[0]->result;

            if (!$canBeParrain) {
                return response()->json([
                    'errors' => [
                        'general' => ["Les informations fournies ne correspondent pas à un électeur éligible."]
                    ]
                ], 422);
            }

            // Vérifier si l'électeur n'est pas déjà enregistré comme parrain
            $existingParrain = Parrain::where('numero_electeur', $request->numero_electeur)
            ->first();
            
            if ($existingParrain) {
                return response()->json([
                    'errors' => [
                        'general' => ["Vous êtes déjà enregistré comme parrain."]
                    ]
                ], 422);
            }

            // Stocker temporairement les informations validées en session
            $request->session()->put('electeur_verified', [
                'numero_electeur' => $request->numero_electeur,
                'cin' => $request->cin,
                'nom' => $request->nom,
                'bureau_vote' => $request->bureau_vote
            ]);

            return response()->json([
                'message' => 'Vérification réussie',
                'next_step' => 'contact_info'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'general' => ["Une erreur est survenue lors de la vérification. Veuillez réessayer."]
                ]
            ], 500);
        }
    }

    public function showContactForm()
    {
        if (!session()->has('electeur_verified')) {
            return redirect()->route('parrain.activation');
        }

        return view('parrains.contact_info');
    }

    public function saveContactInfo(Request $request)
    {
        if (!session()->has('electeur_verified')) {
            return redirect()->route('parrain.activation');
        }

        try {
            $request->validate([
                'telephone' => [
                    'required',
                    'regex:/^(70|75|76|77|78)[0-9]{7}$/',
                    'unique:parrains,telephone'
                ],
                'email' => 'required|string',
                'prenom' => 'required|string|max:100',
                'date_naissance' => 'required|date',
                'lieu_naissance' => 'required|string|max:100',
                'sexe' => 'required|in:M,F'
            ]);
            
            $electeurInfo = session()->get('electeur_verified');
            
            DB::beginTransaction();
            try {
                // Créer un code d'authentification aléatoire
                $codeAuthentification = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
                
                // Créer le parrain
                $parrain = Parrain::create([
                    'numero_electeur' => $electeurInfo['numero_electeur'],
                    'telephone' => $request->telephone,
                    'email' => $request->email,
                    'code_authentification' => $codeAuthentification,
                    'date_inscription' => now(),
                    'candidat_id' => null
                ]);
                
                // Créer le compte utilisateur
                $user = User::create([
                    'nom_utilisateur' => $electeurInfo['numero_electeur'],
                    'password' => Hash::make($electeurInfo['cin']),
                    'userable_id' => $parrain->id,
                    'userable_type' => Parrain::class,
                    'date_creation' => now()
                ]);
                

                // Envoyer l'e-mail d'activation du compte
                $good = $this->mailingService->envoyerMailActivationCompte($parrain, $electeurInfo['cin']);
                
                if (!$good) {
                    throw new \Exception("Erreur lors de l'envoi de l'e-mail d'activation.");
                }

                DB::commit();
                
                // Stocker les identifiants en session pour la page de succès
                session()->put('username', $electeurInfo['numero_electeur']);
                session()->put('password', $electeurInfo['cin']);
                session()->put('success_message', 'Votre compte a été créé et activé avec succès!');
                
                // Nettoyer la session d'information de l'électeur
                session()->forget('electeur_verified');
                
                return redirect()->route('parrain.activation.success');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            dd($e);

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            dd($e);
            return back()->withErrors([
                'general' => "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer."
            ])->withInput();
        }
    }

    public function showSuccess()
    {
        // Vérifier si les informations nécessaires sont présentes en session
        if (!session()->has('username') || !session()->has('password')) {
            return redirect()->route('parrain.activation')->with('error', 'Veuillez compléter le processus d\'activation.');
        }
        
        return view('parrains.success');
    }
}
