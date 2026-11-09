<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KitapController;
use App\Http\Controllers\OduncController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Hafta 2: Routing
|--------------------------------------------------------------------------
|
| Hafta 2: Route tanımlamaları
| Hafta 3: Route'a isim verme, middleware
| Hafta 9: Resource Controller route tanımlaması
|
*/

// -------------------------------------------------------
// AUTH ROUTES - Hafta 3: Route isimlendirme
// -------------------------------------------------------
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// -------------------------------------------------------
// KORUNAN ROUTES - Hafta 3: Middleware kullanımı
// -------------------------------------------------------
Route::middleware('giris.kontrol')->group(function () {

    // Anasayfa yönlendirmesi
    Route::get('/', function () {
        return redirect()->route('kitaplar.index');
    });

    // Hafta 9: Resource Controller - tek satırda 7 route oluşturur
    // GET    /kitaplar           → KitapController@index
    // GET    /kitaplar/create    → KitapController@create
    // POST   /kitaplar           → KitapController@store
    // GET    /kitaplar/{id}      → KitapController@show
    // GET    /kitaplar/{id}/edit → KitapController@edit
    // PUT    /kitaplar/{id}      → KitapController@update
    // DELETE /kitaplar/{id}      → KitapController@destroy
    Route::resource('kitaplar', KitapController::class);

    // Hafta 9: Resource Controller - Ödünç işlemleri
    Route::resource('odunc', OduncController::class);

});
