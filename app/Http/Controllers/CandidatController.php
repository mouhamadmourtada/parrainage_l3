<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Electeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\MailingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CandidatController extends Controller
{
    protected $mailingService;

    /**
     * Constructeur avec dépendance du MailingService
     * 
     * Note: Le middleware 'auth' est déjà appliqué au niveau des routes,
     * mais nous le mettons également ici pour plus de sécurité.
     */
    public function __construct(MailingService $mailingService)
    {
        $this->middleware('auth');
        $this->mailingService = $mailingService;
    }

    /**
     * Vérifie que l'utilisateur authentifié est bien un agent DGE
     * 
     * @return boolean
     */
    private function checkAgentDGEAuth()
    {
        // Tout utilisateur authentifié est considéré comme un agent DGE pour l'instant
        // Cette méthode sera améliorée ultérieurement avec des vérifications de rôles plus précises
        if (!Auth::check()) {
            abort(403, 'Accès non autorisé. Authentification requise.');
        }
        
        return true;
    }

    /**
     * Affiche le formulaire de recherche de candidat par numéro d'électeur
     */
    public function showRechercheForm()
    {
        $this->checkAgentDGEAuth();
        return view('candidats.recherche');
    }

    /**
     * Vérifie si le numéro d'électeur est valide
     */
    public function verifierNumeroElecteur(Request $request)
    {
        $this->checkAgentDGEAuth();
        
        $request->validate([
            'numero_electeur' => 'required|string|max:20'
        ]);

        $numeroElecteur = $request->input('numero_electeur');

        // Vérifier si le candidat est déjà enregistré
        $candidatExistant = Candidat::where('numero_electeur', $numeroElecteur)->first();
        if ($candidatExistant) {
            return redirect()->route('agent_dge.candidats.recherche')
                ->with('error', 'Candidat déjà enregistré !');
        }

        // Vérifier si l'électeur existe dans le fichier électoral
        $electeur = Electeur::where('numero_electeur', $numeroElecteur)->first();
        if (!$electeur) {
            return redirect()->route('agent_dge.candidats.recherche')
                ->with('error', 'Le candidat considéré n\'est pas présent dans le fichier électoral');
        }

        // Rediriger vers le formulaire d'inscription avec les informations de l'électeur
        return redirect()->route('agent_dge.candidats.inscription.form', ['numero_electeur' => $numeroElecteur]);
    }

    /**
     * Affiche le formulaire d'inscription du candidat
     */
    public function showInscriptionForm(Request $request)
    {
        $this->checkAgentDGEAuth();
        
        $numeroElecteur = $request->query('numero_electeur');
        if (!$numeroElecteur) {
            return redirect()->route('agent_dge.candidats.recherche')
                ->with('error', 'Numéro d\'électeur non spécifié');
        }

        $electeur = Electeur::where('numero_electeur', $numeroElecteur)->first();
        if (!$electeur) {
            return redirect()->route('agent_dge.candidats.recherche')
                ->with('error', 'Le candidat considéré n\'est pas présent dans le fichier électoral');
        }

        return view('candidats.inscription', compact('electeur'));
    }

    /**
     * Enregistre un nouveau candidat
     */
    public function inscrireCandidat(Request $request)
    {
        $this->checkAgentDGEAuth();
        
        // Validation des entrées
        $validator = Validator::make($request->all(), [
            'numero_electeur' => 'required|string|max:20|exists:electeurs,numero_electeur',
            'email' => 'required|email|unique:candidats,email',
            'telephone' => 'required|string|max:20',
            'parti_politique' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'photo' => 'required|image|max:2048',
            'couleur1' => 'required|string|max:7',
            'couleur2' => 'required|string|max:7',
            'couleur3' => 'required|string|max:7',
            'url_page' => 'nullable|url|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier si le candidat est déjà enregistré
        $numeroElecteur = $request->input('numero_electeur');
        $candidatExistant = Candidat::where('numero_electeur', $numeroElecteur)->first();
        if ($candidatExistant) {
            return redirect()->route('agent_dge.candidats.recherche')
                ->with('error', 'Candidat déjà enregistré !');
        }

        try {
            // Stocker la photo du candidat
            $photoPath = null;
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $file = $request->file('photo');
                $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $photoPath = $file->storeAs('candidats/photos', $photoName, 'public');
                
                // Vérification que le fichier a bien été enregistré
                if (!Storage::disk('public')->exists($photoPath)) {
                    throw new \Exception('L\'image n\'a pas pu être sauvegardée.');
                }
                
                Log::info('Photo du candidat téléchargée avec succès: ' . $photoPath);
            } else {
                throw new \Exception('La photo du candidat est requise et doit être une image valide.');
            }

            // Générer un code de sécurité aléatoire à 6 chiffres
            $codeSecurite = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Générer un code de validation pour l'authentification
            $codeValidation = Str::random(5);

            // Créer le candidat
            $candidat = Candidat::create([
                'numero_electeur' => $numeroElecteur,
                'email' => $request->input('email'),
                'telephone' => $request->input('telephone'),
                'parti_politique' => $request->input('parti_politique'),
                'slogan' => $request->input('slogan'),
                'photo_url' => $photoPath,
                'couleur1' => $request->input('couleur1'),
                'couleur2' => $request->input('couleur2'),
                'couleur3' => $request->input('couleur3'),
                'url_page' => $request->input('url_page'),
                'code_securite' => $codeSecurite,
                'code_validation' => $codeValidation,
                'date_enregistrement' => now(),
            ]);

            // Créer un compte utilisateur pour le candidat
            $electeur = Electeur::where('numero_electeur', $numeroElecteur)->first();
            $user = new User();
            $user->nom_utilisateur = $request->input('email');
            $user->email = $request->input('email');
            $user->password = Hash::make($codeSecurite);
            $user->userable_id = $candidat->id;
            $user->userable_type = Candidat::class;
            $user->date_creation = now();
            $user->save();

            // Envoyer le code de sécurité par email et SMS
            try {
                $this->mailingService->envoyerCodeSecurite(
                    $request->input('email'),
                    $request->input('telephone'),
                    $electeur->nom . ' ' . $electeur->prenom,
                    $codeSecurite
                );
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi du code de sécurité : ' . $e->getMessage());
                // L'erreur d'envoi ne doit pas bloquer la création du candidat
            }

            return redirect()->route('agent_dge.candidats.confirmation', ['id' => $candidat->id])
                ->with('success', 'La candidature a été enregistrée avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement du candidat : ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement du candidat : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche la page de confirmation après l'inscription
     */
    public function showConfirmation($id)
    {
        $this->checkAgentDGEAuth();
        
        $candidat = Candidat::with('electeur')->findOrFail($id);
        return view('candidats.confirmation', compact('candidat'));
    }

    /**
     * Affiche la liste des candidats
     */
    public function index()
    {
        $this->checkAgentDGEAuth();
        
        $candidats = Candidat::with('electeur')->orderBy('date_enregistrement', 'desc')->paginate(10);
        return view('candidats.index', compact('candidats'));
    }

    /**
     * Affiche les détails d'un candidat
     */
    public function show($id)
    {
        $this->checkAgentDGEAuth();
        
        $candidat = Candidat::with('electeur')->findOrFail($id);
        return view('candidats.details', compact('candidat'));
    }

    /**
     * Génère un nouveau code de sécurité pour un candidat
     */
    public function genererNouveauCode($id)
    {
        $this->checkAgentDGEAuth();
        
        $candidat = Candidat::with('electeur')->findOrFail($id);
        
        // Générer un nouveau code de sécurité
        $nouveauCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $candidat->code_securite = $nouveauCode;
        $candidat->save();

        // Mettre à jour le mot de passe de l'utilisateur associé
        if ($candidat->user) {
            $candidat->user->password = Hash::make($nouveauCode);
            $candidat->user->save();
        }

        // Envoyer le nouveau code par email et SMS
        try {
            $this->mailingService->envoyerCodeSecurite(
                $candidat->email,
                $candidat->telephone,
                $candidat->electeur->nom . ' ' . $candidat->electeur->prenom,
                $nouveauCode
            );
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du nouveau code de sécurité : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi du code de sécurité. Le code a bien été généré mais n\'a pas pu être envoyé.');
        }

        return redirect()->back()->with('success', 'Un nouveau code de sécurité a été généré et envoyé au candidat.');
    }
}