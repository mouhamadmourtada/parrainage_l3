<?php

use App\Http\Controllers\ParrainController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\AgentDGEController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\UserAgentController;
use App\Http\Controllers\Auth\AgentDGEAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes pour l'activation du compte parrain
Route::prefix('parrain')->name('parrain.')->group(function () {
    Route::get('/activation', [ParrainController::class, 'showActivationForm'])->name('activation');
    Route::post('/verify', [ParrainController::class, 'verifyElecteur'])->name('verify');
    Route::get('/contact', [ParrainController::class, 'showContactForm'])->name('contact');
    Route::post('/save-contact', [ParrainController::class, 'saveContactInfo'])->name('save-contact');
    Route::get('/success', [ParrainController::class, 'showSuccess'])->name('activation.success');
});

// Routes pour le parrainage électoral (site public)
Route::prefix('parrainage')->name('parrainage.')->group(function () {
    // Étape 1: Vérification de l'électeur
    Route::get('/', [ParrainageController::class, 'showVerificationForm'])->name('verification');
    Route::post('/verifier', [ParrainageController::class, 'verifierElecteur'])->name('verifier');
    
    // Étape 2: Saisie du code d'authentification
    Route::get('/authentification', [ParrainageController::class, 'showAuthentificationForm'])->name('authentification');
    Route::post('/authentifier', [ParrainageController::class, 'authentifier'])->name('authentifier');
    
    // Routes protégées par middleware auth
    Route::middleware('auth')->group(function() {
        // Étape 3: Choix du candidat
        Route::get('/candidats', [ParrainageController::class, 'showCandidats'])->name('candidats');
        Route::post('/choisir-candidat', [ParrainageController::class, 'choisirCandidat'])->name('choisir.candidat');
        
        // Étape 4: Confirmation par code à usage unique
        Route::get('/confirmation', [ParrainageController::class, 'showConfirmation'])->name('confirmation');
        Route::post('/confirmer', [ParrainageController::class, 'confirmer'])->name('confirmer');
        
        // Étape 5: Succès
        Route::get('/succes', [ParrainageController::class, 'showSuccess'])->name('succes');
    });
});

// Routes d'authentification pour les agents DGE
Route::prefix('agent-dge')->name('agent_dge.')->group(function () {
    // Page d'accueil publique pour les agents DGE
    Route::get('/', function () {
        return view('agent_dge.welcome');
    })->name('welcome');
    
    // Login routes
    Route::get('/login', [AgentDGEAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AgentDGEAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AgentDGEAuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // Routes d'accès au dashboard et aux fonctionnalités (protégées)
    Route::middleware(['auth'])->group(function () { // Removed 'role:agent_dge' temporarily
        // Dashboard
        Route::get('/dashboard', function () {
            return view('agent_dge.dashboard');
        })->name('dashboard');
        
        // Importation du fichier électoral
        Route::get('/import', [AgentDGEController::class, 'showImportForm'])->name('import.form');
        Route::post('/import', [AgentDGEController::class, 'importFichierElectoral'])->name('import');
        
        // Vérification du fichier importé
        Route::get('/verification/{upload_id}', [AgentDGEController::class, 'showVerificationPage'])->name('verification');
        
        // Validation de l'importation
        Route::post('/valider/{upload_id}', [AgentDGEController::class, 'validerImportation'])->name('valider');
        
        // Historique des uploads
        Route::get('/historique-uploads', [AgentDGEController::class, 'showUploadHistory'])->name('historique-uploads');
        
        // Gestion des candidats (maintenant sous le middleware auth des agents DGE)
        Route::prefix('candidats')->name('candidats.')->group(function () {
            // Recherche de candidat par numéro d'électeur
            Route::get('/', [CandidatController::class, 'showRechercheForm'])->name('recherche');
            Route::post('/verifier', [CandidatController::class, 'verifierNumeroElecteur'])->name('verifier');
            
            // Inscription d'un nouveau candidat
            Route::get('/inscription', [CandidatController::class, 'showInscriptionForm'])->name('inscription.form');
            Route::post('/inscription', [CandidatController::class, 'inscrireCandidat'])->name('inscription');
            
            // Confirmation après inscription
            Route::get('/confirmation/{id}', [CandidatController::class, 'showConfirmation'])->name('confirmation');
            
            // Liste des candidats
            Route::get('/liste', [CandidatController::class, 'index'])->name('liste');
            
            // Détails d'un candidat
            Route::get('/details/{id}', [CandidatController::class, 'show'])->name('details');
            
            // Générer un nouveau code de sécurité
            Route::post('/generer-code/{id}', [CandidatController::class, 'genererNouveauCode'])->name('generer-code');
        });
        
        // Gestion des utilisateurs agents DGE
        Route::prefix('utilisateurs')->name('users.')->group(function () {
            Route::get('/', [UserAgentController::class, 'index'])->name('index');
            Route::get('/create', [UserAgentController::class, 'create'])->name('create');
            Route::post('/', [UserAgentController::class, 'store'])->name('store');
            Route::get('/{id}', [UserAgentController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UserAgentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserAgentController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserAgentController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [UserAgentController::class, 'toggleStatus'])->name('toggle-status');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Routes Espace Candidat
|--------------------------------------------------------------------------
*/

// Routes pour l'accès des candidats à leur tableau de bord
Route::prefix('espace-candidat')->group(function () {
    // Connexion
    Route::get('/connexion', [App\Http\Controllers\CandidatController::class, 'showLoginForm'])->name('candidat.login');
    Route::post('/connexion', [App\Http\Controllers\CandidatController::class, 'authenticate'])->name('candidat.authenticate');
    Route::get('/deconnexion', [App\Http\Controllers\CandidatController::class, 'logout'])->name('candidat.logout');
    
    // Tableau de bord (accessible uniquement après connexion)
    Route::get('/tableau-de-bord', [App\Http\Controllers\CandidatController::class, 'dashboard'])->name('candidat.dashboard');
});
