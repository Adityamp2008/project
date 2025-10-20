<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AtkItemController;
use App\Http\Controllers\LoginController;
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
    Route::resource('atk', AtkItemController::class);
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

Route::middleware(['auth','role:petugas|admin|kepdin'])->group(function(){
    
});


require __DIR__.'/auth.php';
