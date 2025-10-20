<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginAction'])->name('login.action');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Semua route yang butuh login

//routing admin
Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth'
], function() {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');
});

//routing petugas
Route::group([
    'prefix' => 'petugas',
    'middleware' => 'auth'
], function() {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('petugas.dashboard');
});

//routing kepdin
Route::group([
    'prefix' => 'kepdin',
    'middleware' => 'auth'
], function() {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('kepdin.dashboard');
});


Route::middleware(['/dashboard'])->group(function () {
    Route::resource('assets', AssetsController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('kondisi', KondisiController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('riwayat', RiwayatController::class);

});

require __DIR__.'/auth.php';
