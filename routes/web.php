<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NiveauScolaireController;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [authController::class, 'showLogin'])
    ->middleware('guest') //guest => visiteur
    ->name('login');

Route::post('/login', [authController::class, 'authenticate'])
    ->middleware('guest') //guest => visiteur
    ->name('login.post');

Route::group([
        // tout est protégé par la middleware auth
        "middleware" => "auth"
    ], function() {

        Route::get('/', function () {
            //return Inertia::render('test');
            return inertia('Home');
        })->name('home');

        Route::post('/logout', [authController::class, 'logout'])->name('logout');
        
        Route::get('/etudiant', [EtudiantController::class, 'index'] )->name('etudiant.index');
        Route::post('/etudiant', [EtudiantController::class, 'store'] )->name('etudiant.store');
        Route::get('/etudiant/create', [EtudiantController::class, 'create'] )->name('etudiant.create');
        Route::get('/etudiant/edit/{etudiant}', [EtudiantController::class, 'edit'] )->name('etudiant.edit');   // accéder à la modification
        Route::post('/etudiant/{etudiant}', [EtudiantController::class, 'update'] )->name('etudiant.update');    // effectuer la modification
        Route::delete('/etudiant/{etudiant}', [EtudiantController::class, 'delete'] )->name('etudiant.delete');    
        
        Route::get('/niveauscolaire', [NiveauScolaireController::class, 'index'] )->name('niveauscolaire.index');
        Route::get('/niveauscolaire/edit/{niveauScolaire}', [NiveauScolaireController::class, 'edit'] )->name('niveauscolaire.edit');
        Route::post('/niveauscolaire', [NiveauScolaireController::class, 'store'] )->name('niveauscolaire.store');
        Route::put('/niveauscolaire/{niveauScolaire}', [NiveauScolaireController::class, 'update'] )->name('niveauscolaire.update');
        Route::delete('/niveauscolaire/{niveauScolaire}', [NiveauScolaireController::class, 'delete'] )->name('niveauscolaire.delete');
    
});

