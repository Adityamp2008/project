<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    AssetsController,
    AtkItemController,
    KelayakanAssetsController,
    UserController
};
use App\Http\Controllers\petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\kepdin\DashboardController as KepdinDashboard;


// === Auth ===
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginAction'])->name('login.action');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =================================================
// ============== SUPER ADMIN ROUTE ================
// =================================================
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'role:super_admin']
], function() {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // --- Modul utama ---
    Route::resource('assets', AssetsController::class);
    Route::resource('atk', AtkItemController::class);
    Route::resource('kelayakanassets', KelayakanAssetsController::class);
    Route::resource('users', UserController::class);

    // --- Export / Report ---
    Route::get('atk/export/excel', [AtkItemController::class, 'exportExcel'])->name('atk.exportExcel');
    Route::get('atk/export/pdf', [AtkItemController::class, 'exportPdf'])->name('atk.exportPdf');

    // --- Barang Masuk & Keluar ---
    Route::get('atk/{atk}/in', [AtkItemController::class, 'stockInForm'])->name('atk.stockin.form');
    Route::post('atk/{atk}/in', [AtkItemController::class, 'stockIn'])->name('atk.stockin');
    Route::get('atk/{atk}/out', [AtkItemController::class, 'stockOutForm'])->name('atk.stockout.form');
    Route::post('atk/{atk}/out', [AtkItemController::class, 'stockOut'])->name('atk.stockout');

    // --- Laporan ---
    Route::get('laporan/report', [AtkItemController::class, 'report'])->name('laporan.report');
    Route::get('laporan/report/pdf', [AtkItemController::class, 'reportPdf'])->name('laporan.report.pdf');
    Route::get('laporan/report/excel', [AtkItemController::class, 'exportExcel'])->name('laporan.report.excel');
});


// =================================================
// ============== PETUGAS ROUTE ====================
// =================================================
Route::group([
    'prefix' => 'petugas',
    'middleware' => ['auth', 'role:petugas']
], function() {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('petugas.dashboard');
    // nanti bisa ditambah modul khusus petugas (input aset, stok, laporan pribadi, dst)
});


// =================================================
// ============== KEPALA DINAS ROUTE ===============
// =================================================
Route::group([
    'prefix' => 'kepdin',
    'middleware' => ['auth', 'role:kepdin']
], function() {
    Route::get('/dashboard', [KepdinDashboard::class, 'index'])->name('kepdin.dashboard');
    // nanti tambahin modul laporan & kelayakan aset
});


require __DIR__.'/auth.php';
