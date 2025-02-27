<?php

use App\Http\Controllers\ParrainController;
use App\Http\Controllers\ParrainageController;
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
});

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

// Suppression des routes dupliquées qui ont été ajoutées précédemment
