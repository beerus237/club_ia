<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\AdminController;
//use App\Http\Controllers\AdminActualiteController;
//use App\Http\Controllers\AdminEvenementController;
//use App\Http\Controllers\AdminProjetController;
use App\Http\Controllers\Admin\ContributionAdminController;
use App\Http\Controllers\Admin\ActualiteAdminController;
use App\Http\Controllers\Admin\EvenementAdminController;
use App\Http\Controllers\Admin\ProjetAdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StorageFileController;

use Inertia\Inertia;

// Pages principales
Route::get('/', [HomeController::class, 'index'])->name('home');

// Filet de sécurité : sert les fichiers uploadés directement via Laravel si
// le lien symbolique public/storage n'existe pas (fréquent sous Windows sans
// mode développeur activé, ou sur certains hébergements sans support des
// liens symboliques). Si le lien existe, Apache/Nginx sert le fichier réel
// avant même d'atteindre cette route : aucun risque de conflit.
Route::get('/storage/{path}', [StorageFileController::class, 'show'])
    ->where('path', '.*')
    ->name('storage.fallback');


Route::get('/espace-etudiant', function () {
    return Inertia::render('EspaceEtudiant');
})->name('espace-etudiant');

// Routes avec contrôleurs
Route::get('/actualite', [ActualiteController::class, 'index'])->name('actualite');
Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements');
Route::post('/evenements/{id}/inscrire', [EvenementController::class, 'inscrire'])->name('evenements.inscrire');

Route::get('/realisations', [ProjetController::class, 'index'])->name('realisations');

Route::get('/collecte-donnees', [ContributionController::class, 'create'])->name('collecte-donnees');
Route::post('/contributions', [ContributionController::class, 'store'])->name('contributions.store');
Route::get('/resultats-analyse', [ContributionController::class, 'statistiques'])->name('resultats-analyse');

// Pages statiques
Route::get('/objectifs', function () {
    return Inertia::render('Objectifs');
})->name('objectifs');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

// Connexion admin (mot de passe partagé, hors protection)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Routes admin protégées par mot de passe
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/settings', [AdminAuthController::class, 'showSettings'])->name('settings');
    Route::post('/settings/password', [AdminAuthController::class, 'updatePassword'])->name('settings.password');

    // Routes contributions admin
    Route::get('/contributions', [ContributionAdminController::class, 'index'])->name('contributions.index');
    Route::get('/contributions/{contribution}', [ContributionAdminController::class, 'show'])->name('contributions.show');
    Route::post('/contributions/{contribution}/approve', [ContributionAdminController::class, 'approve'])->name('contributions.approve');
    Route::post('/contributions/{contribution}/reject', [ContributionAdminController::class, 'reject'])->name('contributions.reject');
    Route::get('/contributions/{contribution}/download', [ContributionAdminController::class, 'download'])->name('contributions.download');

    //ROUTES POUR ACTUALITES
    Route::resource('actualites', ActualiteAdminController::class);

    //EVENEMENTS
     Route::resource('evenements', EvenementAdminController::class);

     Route::resource('projets', ProjetAdminController::class);

    Route::resource('carousel', \App\Http\Controllers\Admin\CarouselController::class)->names('carousel');

    Route::get('meilleure-realisation/edit', [\App\Http\Controllers\Admin\MeilleureRealisationController::class, 'edit'])
        ->name('meilleure-realisation.edit');
    Route::put('meilleure-realisation', [\App\Http\Controllers\Admin\MeilleureRealisationController::class, 'update'])
        ->name('meilleure-realisation.update');
});


