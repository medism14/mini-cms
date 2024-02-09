<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ArticleController;

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
        })->name('auth');

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

            Route::match(['get', 'post'], '/config', [UserController::class, 'config'])->name('config');
            //Users
        Route::prefix('/site')->name('site.')->group(function () {
            Route::get('/', [UserController::class, 'redirection']);
            Route::match(['get', 'post'], '/{siteName}', [UserController::class, 'index'])->name('dashboard');
        });

        //Sites
        Route::prefix('/sites')->name('sites.')->group (function () {
            Route::post('/editSiteName', [SiteController::class, 'editSiteName'])->name('editSiteName');
            Route::post('/editMenuType', [SiteController::class, 'editMenuType'])->name('editMenuType');
            Route::post('/editBackgroundColor', [SiteController::class, 'editBackgroundColor'])->name('editBackgroundColor');
            Route::post('/editFontColor', [SiteController::class, 'editFontColor'])->name('editFontColor');
            Route::post('/editSectionColor', [SiteController::class, 'editSectionColor'])->name('editSectionColor');
        });

        //Pages
        Route::prefix('/pages')->name('pages.')->group (function () {
            Route::post('/add', [PageController::class, 'add'])->name('add');
            Route::post('/edit/{id}', [PageController::class, 'edit'])->name('edit');
            Route::delete('/delete/{id}', [PageController::class, 'delete'])->name('delete');
            Route::get('/getPage/{id}', [PageController::class, 'getPage'])->name('getPage');
        });

        //Articles
        Route::prefix('/articles')->name('articles.')->group (function () {
            Route::post('/add', [ArticleController::class, 'add'])->name('add');
            Route::post('/edit/{id}', [ArticleController::class, 'edit'])->name('edit');
            Route::get('/configArticle/{id}', [ArticleController::class, 'configArticle'])->name('configArticle');
            Route::get('/getArticle/{id}', [ArticleController::class, 'getArticle'])->name('getArticle');
            Route::get('/{id}', [ArticleController::class, 'view'])->name('view');
            Route::delete('/delete/{id}', [ArticleController::class, 'delete'])->name('delete');
        });

        //Commentaires
        Route::prefix('/comments')->name('comments.')->group (function () {
            Route::post('/add/{id}', [CommentController::class, 'add'])->name('add');
            Route::delete('/delete/{id}', [CommentController::class, 'delete'])->name('delete');
        });

    });
});


