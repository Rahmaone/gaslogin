<?php

use App\Http\Controllers\BelajarController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
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

Route::get('/', [LoginController::class, 'indexadmin'])->name('login');

Route::get('/enkripsi', [BelajarController::class, 'enkripsi'])->name('enkripsi');
Route::get('/enkripsi-detail/{params}', [BelajarController::class, 'enkripsi_detail'])->name('enkripsi-detail');

Route::get('/hashing', [BelajarController::class, 'hashing'])->name('hashing');

Route::get('locale/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale');


Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
Route::post('/forgot-password-act', [LoginController::class, 'forgot_password_act'])->name('forgot-password-act');

Route::get('/validasi-forgot-password/{token}', [LoginController::class, 'validasi_forgot_password'])->name('validasi-forgot-password');
Route::post('/validasi-forgot-password-act', [LoginController::class, 'validasi_forgot_password_act'])->name('validasi-forgot-password-act');

Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/user', [HomeController::class, 'index'])->name('index');
    Route::get('/assets', [HomeController::class, 'assets'])->name('assets');
    Route::get('/create', [HomeController::class, 'create'])->name('user.create');
    Route::post('/store', [HomeController::class, 'store'])->name('user.store');

    Route::get('/clientside', [DataTableController::class, 'clientside'])->name('clientside');
    Route::get('/serverside', [DataTableController::class, 'serverside'])->name('serverside');

    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
    Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('user.detail');
    Route::put('/update/{id}', [HomeController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');

    Route::get('/berita', [BeritaController::class, 'indexberita'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'createberita'])->name('berita.create');
    Route::post('/berita/store', [BeritaController::class, 'storeberita'])->name('berita.store');
    Route::get('/berita/edit/{id}', [BeritaController::class, 'editberita'])->name('berita.edit');
    Route::put('/berita/update/{id}', [BeritaController::class, 'updateberita'])->name('berita.update');
    Route::delete('/berita/delete/{id}', [BeritaController::class, 'deleteberita'])->name('berita.delete');

    Route::get('game', [GameController::class, 'indexgame'])->name('game.index');
    Route::get('game/create', [GameController::class, 'creategame'])->name('game.create');
    Route::post('game/store', [GameController::class, 'storegame'])->name('game.store');
    Route::get('game/edit/{id}', [GameController::class, 'editgame'])->name('game.edit'); 
    Route::put('game/update/{id}', [GameController::class, 'updategame'])->name('game.update');
    Route::delete('game/delete/{id}', [GameController::class, 'deletegame'])->name('game.delete');    


    Route::group(['prefix' => 'belajar'], function () {
        Route::get('/cache', [BelajarController::class, 'cache'])->name('cache');
        Route::get('/import', [BelajarController::class, 'import'])->name('import');
        Route::post('/import-proses', [BelajarController::class, 'import_proses'])->name('import-proses');
    });
});

//GuestRoute
Route::get('/home', [GuestController::class, 'home'])->name('home');
Route::get('/detailtour', [GuestController::class, 'detailtour'])->name('detailtour');
Route::get('/detailtourvalo', [GuestController::class, 'detailtourvalo'])->name('detailtourvalo');
Route::get('/detaildonation', [GuestController::class, 'detaildonation'])->name('detaildonation');
Route::get('/mainblog', [GuestController::class, 'mainblog'])->name('mainblog');
Route::get('/about', [GuestController::class, 'about'])->name('about');
Route::get('/blog', [GuestController::class, 'blog'])->name('blog');
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');
Route::get('/tournament', [GuestController::class, 'tournament'])->name('tournament');

//UserOnlyRoute
Route::get('/createtour', [UserController::class, 'createtour'])->name('createtour');

//UserAuthRoute
Route::get('/login', [LoginController::class, 'indexuser'])->name('loginUser');
Route::post('/loginproses', [LoginController::class, 'loginproses'])->name('loginproses');
Route::get('/forgotpassword', [LoginController::class,'forgotpassworduser'])->name('forgotpassworduser');
Route::post('/forgotpassworduseract', [LoginController::class, 'forgotpassworduseract'])->name('forgotpassworduseract');
Route::get('/registeruser', [LoginController::class,'registeruser'])->name('registeruser');
Route::post('/registerprosesuser', [LoginController::class,'registerprosesuser'])->name('registerprosesuser');
Route::get('/logoutuser', [LoginController::class,'logoutuser'])->name('logoutuser');
Route::get('/validasiforgotpassworduser/{token}', [LoginController::class, 'validasiforgotpassworduser'])->name('validasiforgotpassworduser');
Route::post('/validasiforgotpasswordactuser', [LoginController::class, 'validasiforgotpasswordactuser'])->name('validasiforgotpasswordactuser');
