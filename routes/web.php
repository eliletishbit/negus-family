<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PootestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ================================================
// ROUTES ACCESSIBLES AUX UTILISATEURS NON AUTHENTIFIÉS
// ================================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

//route public pour eplorer les titres
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/explore/titre/{id}', [ExploreController::class, 'showTitre'])->name('explore.titre.show');

//routes callback et webhook fedapay
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Routes publiques pour les artistes
Route::get('/artistes', [App\Http\Controllers\ArtistePublicController::class, 'index'])->name('artistes.index');
Route::get('/artistes/{id}', [App\Http\Controllers\ArtistePublicController::class, 'show'])->name('artistes.show');



// ================================================
// ROUTES ACCESSIBLES AUX UTILISATEURS AUTHENTIFIÉS
// ================================================

Route::middleware('auth')->group(function () {

    // ============================================
    // PROFIL
    // ============================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ============================================
    // DASHBOARD PRINCIPAL (REDIRECTION SELON LE RÔLE)
    // ============================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Mise à jour du mot de passe
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    //paiement
    Route::post('/payment/titre', [PaymentController::class, 'initierAchatTitre'])->name('payment.titre');
    Route::post('/payment/deblocage', [PaymentController::class, 'initierDeblocage'])->name('payment.deblocage');
    Route::post('/payment/retrait', [PaymentController::class, 'initierRetrait'])->name('payment.retrait');

});


// ================================================
// ROUTES ADMIN
// ================================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    Route::get('/titres', [AdminController::class, 'titres'])->name('titres');
    Route::get('/titres/{titre}/edit', [AdminController::class, 'editTitre'])->name('titres.edit');
    Route::put('/titres/{titre}', [AdminController::class, 'updateTitre'])->name('titres.update');
    Route::delete('/titres/{titre}', [AdminController::class, 'deleteTitre'])->name('titres.delete');

    Route::get('/commandes', [AdminController::class, 'commandes'])->name('commandes');
    Route::get('/commandes/{commande}', [AdminController::class, 'showCommande'])->name('commandes.show');

    Route::get('/retraits', [AdminController::class, 'retraits'])->name('retraits');
    // Actions sur les retraits
    Route::put('/retraits/{retrait}/valider', [AdminController::class, 'validerRetrait'])->name('retraits.valider');
    Route::put('/retraits/{retrait}/rejeter', [AdminController::class, 'rejeterRetrait'])->name('retraits.rejeter');

});

// ================================================
// ROUTES ARTISTE
// ================================================

Route::middleware(['auth', 'role:artiste'])->prefix('artiste')->name('artiste.')->group(function () {

    Route::get('/dashboard', [ArtisteController::class, 'dashboard'])->name('dashboard');

    Route::get('/titres', [ArtisteController::class, 'titres'])->name('titres');
    Route::get('/titres/create', [ArtisteController::class, 'create'])->name('titres.create');
    Route::post('/titres', [ArtisteController::class, 'store'])->name('titres.store');
    Route::get('/titres/{titre}/edit', [ArtisteController::class, 'edit'])->name('titres.edit');
    Route::put('/titres/{titre}', [ArtisteController::class, 'update'])->name('titres.update');
    Route::delete('/titres/{titre}', [ArtisteController::class, 'destroy'])->name('titres.destroy');

    Route::get('/portefeuille', [ArtisteController::class, 'portefeuille'])->name('portefeuille');
    Route::post('/retrait', [ArtisteController::class, 'demanderRetrait'])->name('retrait.store');

});

// ================================================
// ROUTES SPONSOR
// ================================================

Route::middleware(['auth', 'role:sponsor'])->prefix('sponsor')->name('sponsor.')->group(function () {

    Route::get('/dashboard', [SponsorController::class, 'dashboard'])->name('dashboard');

    Route::get('/explorer', [SponsorController::class, 'explorer'])->name('explorer');
    Route::post('/debloquer/{artiste}', [SponsorController::class, 'debloquer'])->name('debloquer');

    Route::get('/contacts', [SponsorController::class, 'contacts'])->name('contacts');

    Route::get('/portefeuille', [SponsorController::class, 'portefeuille'])->name('portefeuille');
    Route::post('/recharger', [SponsorController::class, 'recharger'])->name('recharger');
});

// ================================================
// ROUTES CLIENT
// ================================================

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
 
Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');

    Route::get('/titres', [ClientController::class, 'titres'])->name('titres');
    Route::get('/titres/{id}', [ClientController::class, 'showTitre'])->name('titres.show');

    Route::get('/commandes', [ClientController::class, 'commandes'])->name('commandes');
    Route::get('/commandes/{id}', [ClientController::class, 'showCommande'])->name('commandes.show');

    Route::get('/favoris', [ClientController::class, 'favoris'])->name('favoris');
    Route::post('/favoris/{artiste}', [ClientController::class, 'ajouterFavoris'])->name('favoris.ajouter');
    Route::delete('/favoris/{artiste}', [ClientController::class, 'retirerFavoris'])->name('favoris.retirer');

});

// ================================================
// ROUTES D'AUTHENTIFICATION (GÉNÉRÉES PAR BREEZE)
// ================================================

require __DIR__.'/auth.php';

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "✅ Cache vidé !";
});