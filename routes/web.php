<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AtkItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AssetsController;
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
    Route::resource('assets', AssetsController::class);
    Route::resource('users', UserController::class);

    Route::get('atk/export/excel', [AtkItemController::class, 'exportExcel'])->name('atk.exportExcel');
Route::get('atk/export/pdf', [AtkItemController::class, 'exportPdf'])->name('atk.exportPdf');

// Barang Masuk & Keluar
Route::get('atk/{atk}/in', [AtkItemController::class, 'stockInForm'])->name('atk.stockin.form');
Route::post('atk/{atk}/in', [AtkItemController::class, 'stockIn'])->name('atk.stockin');

Route::get('atk/{atk}/out', [AtkItemController::class, 'stockOutForm'])->name('atk.stockout.form');
Route::post('atk/{atk}/out', [AtkItemController::class, 'stockOut'])->name('atk.stockout');

Route::get('/admin/laporan/report', [AtkItemController::class, 'report'])->name('laporan.report');
Route::get('/admin/laporan/report/pdf', [AtkItemController::class, 'reportPdf'])->name('laporan.report.pdf');
Route::get('/admin/laporan/report/excel', [AtkItemController::class, 'reportExcel'])->name('laporan.report.excel');


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


require __DIR__.'/auth.php';
