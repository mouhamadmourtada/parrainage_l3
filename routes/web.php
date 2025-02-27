<?php

use App\Http\Controllers\ParrainController;
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
