<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('preventBack')->group(function () {

    //Vérification s'il est déjà authentifié ou non
    Route::middleware('redirectIfAuthed')->group(function () {
        //Page authentification
        Route::get('/', function () {
            return view('guest.authentification');
        });

        //Page inscription
        Route::get('/inscription', function () {
            return view('guest.inscription');
        });
    });

    //Connexion
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    //Inscription
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    //Deconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //Utilisateur authentifié
    Route::middleware('auth')->group(function () {

        //Users
        Route::prefix('/users')->name('users.')->group(function () {
            Route::match(['get', 'post'], '/', [UserController::class, 'index'])->name('dashboard');
            Route::get('/config', [UserController::class, 'config'])->name('config');
        });

    });
});


