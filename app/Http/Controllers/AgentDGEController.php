<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueUpload;
use App\Models\ElecteurProbleme;
use App\Models\Electeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;

class AgentDGEController extends Controller
{
    /**
     * Affiche le formulaire d'importation de fichier électoral
     */
    public function showImportForm()
    {
        // Vérifier si un upload valide existe déjà
        $etatUpload = DB::select("SELECT @EtatUploadElecteurs AS etat")[0]->etat ?? false;
        
        return view('agent_dge.import', [
            'etatUpload' => $etatUpload
        ]);
    }

    /**
     * Gère l'import du fichier CSV et la vérification du checksum
     */
    public function importFichierElectoral(Request $request)
    {
        // Validation des entrées
        $validator = Validator::make($request->all(), [
            'fichier_csv' => 'required|file|mimes:csv,txt|max:50000',  // 50MB max
            'checksum_sha256' => 'required|string|size:64',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier si un upload valide existe déjà
        $etatUpload = DB::select("SELECT @EtatUploadElecteurs AS etat")[0]->etat ?? false;
        if ($etatUpload) {
            return redirect()->back()->with('error', 'Un fichier électoral a déjà été validé. L\'importation est désactivée.');
        }

        // Stocker le fichier
        $file = $request->file('fichier_csv');
        $path = $file->store('electoral_files');
        
        // Créer une entrée dans l'historique des uploads
        $upload = new HistoriqueUpload();
        $upload->agent_dge_id = Auth::user()->userable_id;
        $upload->date_upload = now();
        $upload->adresse_ip = $request->ip();
        $upload->checksum_sha256 = $request->input('checksum_sha256');
        $upload->lien_fichier_csv = $path;
        $upload->est_succes = false;
        $upload->save();

        // Lire le contenu du fichier
        $fileContent = file_get_contents(Storage::path($path));
        
        // Vérifier si le contenu du fichier ressemble à un CSV valide
        $firstFewLines = array_slice(explode("\n", $fileContent), 0, 5);
        $hasValidFormat = false;
        
        foreach ($firstFewLines as $line) {
            // Vérifier si la ligne contient au moins 7 points-virgules (8 champs séparés par ;)
            if (substr_count($line, ';') >= 7) {
                $hasValidFormat = true;
                break;
            }
        }
        
        if (!$hasValidFormat) {
            $upload->update([
                'est_succes' => false,
                'message_erreur' => 'Format de fichier invalide. Le fichier CSV doit contenir des lignes avec au moins 8 champs séparés par des points-virgules.'
            ]);
            
            return redirect()->back()->with('error', 'Format de fichier invalide. Veuillez vérifier que votre fichier CSV contient bien les colonnes requises séparées par des points-virgules (;).');
        }
        
        // Étape 1: Contrôler la validité du fichier avec ControlerFichierElecteurs
        $resultat = DB::select("SELECT ControlerFichierElecteurs(?, ?, ?) AS est_valide", [
            $fileContent,
            $request->input('checksum_sha256'),
            $upload->id
        ]);
        
        if (!$resultat[0]->est_valide) {
            return redirect()->back()->with('error', 'Le fichier ne passe pas les contrôles de validité (checksum incorrect ou fichier non UTF-8).');
        }
        
        // Étape 2: Contrôler les électeurs ligne par ligne avec ControlerElecteurs
        try {
            // Appeler la procédure stockée qui traite le fichier complet
            DB::statement("CALL ControlerElecteurs(?, ?)", [
                $fileContent,
                $upload->id
            ]);
            
            // Recharger les informations de l'upload après traitement
            $upload->refresh();
            
            // Rediriger vers la page de vérification
            return redirect()->route('agent_dge.verification', ['upload_id' => $upload->id]);
        } catch (\Exception $e) {
            $upload->update([
                'est_succes' => false,
                'message_erreur' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }

    /**
     * Affiche la page de vérification des électeurs importés
     */
    public function showVerificationPage($upload_id)
    {
        // Récupérer les informations sur l'upload
        $upload = HistoriqueUpload::findOrFail($upload_id);
        
        // Récupérer le nombre d'électeurs importés dans la table temporaire
        $nbElecteurs = DB::table('electeurs_temp')->count();
        
        // Récupérer le nombre d'électeurs problématiques
        $nbProblemes = ElecteurProbleme::where('upload_id', $upload_id)->count();
        
        // Si des problèmes sont détectés, récupérer la liste des électeurs problématiques
        $electeursProblematiques = [];
        if ($nbProblemes > 0) {
            $electeursProblematiques = ElecteurProbleme::where('upload_id', $upload_id)
                ->orderBy('probleme_id')
                ->paginate(50);
        }
        
        return view('agent_dge.verification', [
            'upload' => $upload,
            'nbElecteurs' => $nbElecteurs,
            'nbProblemes' => $nbProblemes,
            'electeursProblematiques' => $electeursProblematiques
        ]);
    }

    /**
     * Exécute la procédure de validation finale de l'import
     */
    public function validerImportation($upload_id)
    {
        // Vérifier si l'upload existe
        $upload = HistoriqueUpload::findOrFail($upload_id);
        
        // Vérifier s'il n'y a pas de problèmes détectés
        $nbProblemes = ElecteurProbleme::where('upload_id', $upload_id)->count();
        
        if ($nbProblemes > 0) {
            return redirect()->back()->with('error', 'Impossible de valider l\'importation car des problèmes ont été détectés.');
        }
        
        // Exécuter la procédure de validation
        DB::statement("CALL ValiderImportation(?)", [$upload_id]);
        
        // Vérifier si la validation a réussi
        $upload->refresh();
        
        if ($upload->est_succes) {
            return redirect()->route('agent_dge.dashboard')->with('success', 'Importation validée avec succès. Le fichier électoral est maintenant actif.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la validation de l\'importation.');
        }
    }

    /**
     * Affiche l'historique des uploads de fichiers électoraux
     */
    public function showUploadHistory()
    {
        // Récupérer tous les uploads avec pagination
        $uploads = HistoriqueUpload::with('agentDge.user')
                    ->orderBy('date_upload', 'desc')
                    ->paginate(10);

        // Pour chaque upload, récupérer le nombre d'électeurs avec problèmes
        foreach ($uploads as $upload) {
            $upload->nb_problemes = ElecteurProbleme::where('upload_id', $upload->id)->count();
            $upload->nb_electeurs = $upload->est_succes ? Electeur::count() : DB::table('electeurs_temp')->count();
        }
        
        return view('agent_dge.historique_uploads', [
            'uploads' => $uploads
        ]);
    }
}