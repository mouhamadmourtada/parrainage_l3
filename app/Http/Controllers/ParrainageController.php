<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Electeur;
use App\Models\Parrain;
use App\Services\MailingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ParrainageController extends Controller
{
    protected $mailingService;

    public function __construct(MailingService $mailingService)
    {
        $this->mailingService = $mailingService;
    }

    /**
     * Affiche le formulaire de vérification d'électeur (étape 1)
     */
    public function showVerificationForm()
    {
        return view('parrainage.verification');
    }

    /**
     * Vérifie les informations de l'électeur
     */
    public function verifierElecteur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_electeur' => 'required|string',
            'cin' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier si l'électeur existe dans la base de données
        $electeur = Electeur::where('numero_electeur', $request->numero_electeur)
            ->where('cin', $request->cin)
            ->first();

        if (!$electeur) {
            return back()->withErrors([
                'general' => 'Les informations fournies ne correspondent pas à un électeur inscrit.'
            ])->withInput();
        }

        // Vérifier si l'électeur a déjà parrainé un candidat
        // $parrainage = DB::table('parrainages')
        //     ->where('electeur_id', $electeur->id)
        //     ->first();
        // pour le parrainge, il y a un attribit candidat_id dans parrain où on sait si l'electeur a déjà parrainé quelqu'un
        // $parrain = Parrain::where('numero_electeur', $electeur->numero_electeur)->first();
        $parrain = $electeur->parrain;
        
        $parrainage = $parrain->candidat_id;

        if ($parrainage) {
            return back()->withErrors([
                'general' => 'Vous avez déjà parrainé un candidat pour cette élection.'
            ])->withInput();
        }

        // Stocker les informations de l'électeur en session pour les étapes suivantes
        session()->put('electeur_verification', [
            'id' => $electeur->id,
            'numero_electeur' => $electeur->numero_carte_electeur,
            'nom' => $electeur->nom,
            'prenom' => $electeur->prenom,
            'date_naissance' => $electeur->date_naissance,
            'bureau_vote' => $electeur->bureau_vote,
            'email' => $electeur->email,
        ]);

        return redirect()->route('parrainage.authentification');
    }

    /**
     * Affiche le formulaire de saisie du code d'authentification (étape 2)
     */
    public function showAuthentificationForm()
    {
        if (!session()->has('electeur_verification')) {
            return redirect()->route('parrainage.verification')
                ->with('error', 'Veuillez vérifier votre identité d\'abord.');
        }

        $electeur = session()->get('electeur_verification');
        
        return view('parrainage.authentification', compact('electeur'));
    }

    /**
     * Vérifie le code d'authentification de l'électeur
     */
    public function authentifier(Request $request)
    {
        if (!session()->has('electeur_verification')) {
            return redirect()->route('parrainage.verification')
                ->with('error', 'Veuillez vérifier votre identité d\'abord.');
        }

        $validator = Validator::make($request->all(), [
            'code_authentification' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $electeurData = session()->get('electeur_verification');
        
        // Vérifier le code d'authentification
        $electeur = Electeur::find($electeurData['id']);
        
        if (!$electeur || $electeur->parrain->code_authentification !== $request->code_authentification) {
            return back()->withErrors([
                'code_authentification' => 'Le code d\'authentification est incorrect.'
            ])->withInput();
        }

        // Récupérer l'utilisateur associé au parrain et l'authentifier
        $user = $electeur->parrain->user;
        
        if (!$user) {
            return back()->withErrors([
                'general' => 'Aucun compte utilisateur n\'est associé à cet électeur.'
            ])->withInput();
        }
        
        auth()->login($user);
        
        // Mettre à jour la session électeur pour les étapes suivantes
        session()->put('electeur_authentifie', true);
        
        return redirect()->route('parrainage.candidats');
    }

    /**
     * Affiche la liste des candidats pour le parrainage (étape 3)
     */
    public function showCandidats()
    {
        if (!auth()->check()) {
            return redirect()->route('parrainage.verification')
                ->with('error', 'Veuillez compléter les étapes précédentes d\'abord.');
        }

        // Récupérer tous les candidats actifs
        $candidats = Candidat::all();
        
        return view('parrainage.candidats', compact('candidats'));
    }

    /**
     * Traite le choix du candidat par l'électeur
     */
    public function choisirCandidat(Request $request)
    {
        // if (!auth()->check()) {
        //     return redirect()->route('parrainage.verification')
        //         ->with('error', 'Veuillez compléter les étapes précédentes d\'abord.');
        // }

        $validator = Validator::make($request->all(), [
            'candidat_id' => 'required|exists:candidats,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        
        // Récupérer les informations de l'électeur et du candidat
        $user = auth()->user();
        $parrain = $user->userable;
        $electeur = $parrain->electeur;
        $candidat = Candidat::find($request->candidat_id);
        
        // Générer un code de confirmation à 5 chiffres
        $codeConfirmation = sprintf('%05d', rand(0, 99999));
        
        // Sauvegarder le code en session
        session()->put('confirmation_parrainage', [
            'code' => $codeConfirmation,
            'candidat_id' => $candidat->id,
            'candidat_nom' => $candidat->nom,
            'candidat_prenom' => $candidat->prenom,
        ]);
        
        // Envoyer le code par email
        $this->envoyerCodeConfirmation($electeur, $parrain, $codeConfirmation, $candidat);
        
        return redirect()->route('parrainage.confirmation');
    }

    /**
     * Envoie le code de confirmation par email
     */
    private function envoyerCodeConfirmation($electeur, $parrain, $code, $candidat)
    {
        $data = [
            'nom' => $electeur->nom,
            'prenom' => $electeur->prenom,
            'code' => $code,
            'candidat_nom' => $candidat->nom,
            'candidat_prenom' => $candidat->prenom,
            'email' => $parrain->email,
        ];

        Mail::send('emails.code-confirmation', $data, function ($message) use ($electeur) {
            $message->to($electeur->parrain->email)
                ->subject('Code de confirmation de votre parrainage');
        });
    }

    /**
     * Affiche le formulaire de confirmation avec code (étape 4)
     */
    public function showConfirmation()
    {
        if (!auth()->check() || !session()->has('confirmation_parrainage')) {
            return redirect()->route('parrainage.verification')
                ->with('error', 'Veuillez compléter les étapes précédentes d\'abord.');
        }

        $candidat = session()->get('confirmation_parrainage');
        
        return view('parrainage.confirmation', compact('candidat'));
    }

    /**
     * Confirme le parrainage avec le code reçu
     */
    public function confirmer(Request $request)
    {
        if (!auth()->check() || !session()->has('confirmation_parrainage')) {
            return redirect()->route('parrainage.verification')
                ->with('error', 'Veuillez compléter les étapes précédentes d\'abord.');
        }

        $validator = Validator::make($request->all(), [
            'code_confirmation' => 'required|string|size:5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $confirmationData = session()->get('confirmation_parrainage');
        $user = auth()->user();
        $parrain = $user->userable;
        $electeur = $parrain->electeur;

        // Vérifier le code de confirmation
        if ($request->code_confirmation !== $confirmationData['code']) {
            return back()->withErrors([
                'code_confirmation' => 'Le code de confirmation est incorrect.'
            ])->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Enregistrer le parrainage
            // $parrain = Parrain::where('numero_electeur', $electeur->numero-)->first();
            // dd($confirmationData["candidat_id"]);

            $parrain->candidat_id = $confirmationData['candidat_id'];
            $parrain->save();

            // // Mise à jour du compteur de parrains pour le candidat
            // Candidat::where('id', $confirmationData['candidat_id'])
            //     ->increment('nombre_parrains');
                
            
            // Envoyer un email de confirmation finale
            $this->envoyerConfirmationFinale($electeur, $parrain, $confirmationData);
            DB::commit();

            // Sauvegarder les informations pour la page de succès
            session()->put('parrainage_success', true);
            
            return redirect()->route('parrainage.succes');
            
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withErrors([
                'general' => 'Une erreur est survenue lors de l\'enregistrement de votre parrainage. Veuillez réessayer.'
            ])->withInput();
        }
    }

    /**
     * Envoie l'email de confirmation finale
     */
    private function envoyerConfirmationFinale($electeur, $parrain, $confirmationData)
    {
        $data = [
            'nom' => $electeur->nom,
            'prenom' => $electeur->prenom,
            'candidat_nom' => $confirmationData['candidat_nom'],
            'candidat_prenom' => $confirmationData['candidat_prenom'],
            'date' => now()->format('d/m/Y H:i'),
        ];

        Mail::send('emails.confirmation-parrainage', $data, function ($message) use ($electeur, $parrain) {
            $message->to($parrain->email)
                ->subject('Confirmation de votre parrainage');
        });
    }

    /**
     * Affiche la page de succès (étape 5)
     */
    public function showSuccess()
    {
        if (!auth()->check() || !session()->has('parrainage_success')) {
            return redirect()->route('parrainage.verification')
                ->with('error', 'Veuillez compléter le processus de parrainage d\'abord.');
        }

        $electeur = auth()->user();
        $confirmationData = session()->get('confirmation_parrainage');

        // Nettoyer les données de session et déconnecter l'utilisateur
        auth()->logout();
        session()->forget(['confirmation_parrainage', 'parrainage_success', 'electeur_verification']);
        
        return view('parrainage.succes', [
            'electeur' => [
                'nom' => $electeur->nom,
                'prenom' => $electeur->prenom,
                'email' => $electeur->email,
                'bureau_vote' => $electeur->bureau_vote,
            ],
            'candidat' => $confirmationData,
        ]);
    }
}
