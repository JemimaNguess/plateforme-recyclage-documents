<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\SignalementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TableauBordController;
use App\Http\Controllers\Admin\UtilisateurAdminController;
use App\Http\Controllers\Admin\SignalementAdminController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\DocumentAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard par défaut de Breeze - redirection selon le rôle
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.tableau-bord');
    }

    return redirect()->route('documents.recherche');
})->middleware(['auth', 'verified'])->name('dashboard');// Routes profil (générées par Breeze, à garder)

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes étudiant (protégées : connecté + email vérifié)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/documents/recherche', [DocumentController::class, 'index'])->name('documents.recherche');
    Route::get('/documents/depot', [DocumentController::class, 'create'])->name('documents.depot');
    Route::post('/documents/depot', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/mes-documents', [DocumentController::class, 'mesDocuments'])->name('documents.mes-documents');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/telecharger', [DocumentController::class, 'download'])->name('documents.download');

    Route::post('/signalements', [SignalementController::class, 'store'])->name('signalements.store');

    // Route AJAX pour charger les matières selon la filière choisie
    Route::get('/matieres/par-filiere/{filiereId}', [MatiereController::class, 'parFiliere'])->name('matieres.par-filiere');
});

// Routes admin (protégées : connecté + email vérifié + rôle admin)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/tableau-bord', [TableauBordController::class, 'index'])->name('tableau-bord');

    Route::get('/utilisateurs', [UtilisateurAdminController::class, 'index'])->name('utilisateurs');
    Route::patch('/utilisateurs/{utilisateur}/statut', [UtilisateurAdminController::class, 'toggleStatut'])->name('utilisateurs.toggle-statut');

    Route::get('/signalements', [SignalementAdminController::class, 'index'])->name('signalements');
    Route::patch('/signalements/{signalement}/traiter', [SignalementAdminController::class, 'traiter'])->name('signalements.traiter');
    Route::patch('/signalements/{signalement}/rejeter', [SignalementAdminController::class, 'rejeter'])->name('signalements.rejeter');
    Route::delete('/signalements/{signalement}/document', [SignalementAdminController::class, 'supprimerDocument'])->name('signalements.supprimer-document');

    Route::get('/categories', [CategorieController::class, 'index'])->name('categories');
    Route::post('/categories/filieres', [CategorieController::class, 'storeFiliere'])->name('categories.filieres.store');
    Route::delete('/categories/filieres/{filiere}', [CategorieController::class, 'destroyFiliere'])->name('categories.filieres.destroy');
    Route::post('/categories/niveaux', [CategorieController::class, 'storeNiveau'])->name('categories.niveaux.store');
    Route::delete('/categories/niveaux/{niveau}', [CategorieController::class, 'destroyNiveau'])->name('categories.niveaux.destroy');
    Route::post('/categories/types-document', [CategorieController::class, 'storeTypeDocument'])->name('categories.types.store');
    Route::delete('/categories/types-document/{typeDocument}', [CategorieController::class, 'destroyTypeDocument'])->name('categories.types.destroy');
    Route::post('/categories/matieres', [CategorieController::class, 'storeMatiere'])->name('categories.matieres.store');
    Route::delete('/categories/matieres/{matiere}', [CategorieController::class, 'destroyMatiere'])->name('categories.matieres.destroy');

    Route::get('/documents', [DocumentAdminController::class, 'index'])->name('documents');
    Route::delete('/documents/{document}', [DocumentAdminController::class, 'destroy'])->name('documents.destroy');
});

require __DIR__.'/auth.php';