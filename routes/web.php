<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    UserController,
    LaporanInventarisController,
    RiwayatPerbaikanController
};
use App\Http\Controllers\petugas\{
    DashboardController as PetugasDashboard,
    AssetsController,
    AtkItemController,
    KelayakanAssetsController,
};
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
    'middleware' => ['auth', 'role:admin']
], function() {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // --- Modul utama ---
    Route::resource('users', UserController::class);
    
    // --- Laporan ---
    Route::get('laporan/report', [AtkItemController::class, 'report'])->name('laporan.report');
    Route::get('laporan/report/pdf', [AtkItemController::class, 'reportPdf'])->name('laporan.report.pdf');
    Route::get('laporan/report/excel', [AtkItemController::class, 'exportExcel'])->name('laporan.report.excel');

    Route::get('admin/riwayat-perbaikan', [RiwayatPerbaikanController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat-perbaikan/create', [RiwayatPerbaikanController::class, 'create'])->name('riwayat.create');
    Route::post('/riwayat-perbaikan', [RiwayatPerbaikanController::class, 'store'])->name('riwayat.store');
    Route::get('/get-items/{type}', [RiwayatPerbaikanController::class, 'getItems'])->name('get.items');

      // Laporan Inventaris
Route::get('laporan/inventaris', [LaporanInventarisController::class, 'index'])->name('laporan.inventaris');
Route::get('laporan/inventaris/pdf', [LaporanInventarisController::class, 'pdf'])->name('laporan.inventaris.pdf');
Route::get('laporan/inventaris/excel', [LaporanInventarisController::class, 'excel'])->name('laporan.inventaris.excel');

    //Laporan perbaikan
// LAPORAN PERBAIKAN
Route::get('laporan/perbaikan', [RiwayatPerbaikanController::class, 'laporan'])->name('laporan.perbaikan');
Route::get('laporan/perbaikan/pdf', [RiwayatPerbaikanController::class, 'laporanPdf'])->name('laporan.perbaikan.pdf');
Route::get('laporan/perbaikan/excel', [RiwayatPerbaikanController::class, 'laporanExcel'])->name('laporan.perbaikan.excel');

});




// =================================================
// ============== PETUGAS ROUTE ====================
// =================================================
Route::group([
    'prefix' => 'petugas',
    'middleware' => ['auth', 'role:petugas']
], function() {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('petugas.dashboard');
    //utama
    Route::resource('assets', AssetsController::class);
    Route::resource('atk', AtkItemController::class);
    Route::resource('kelayakanassets', KelayakanAssetsController::class);

    
    // --- Export / Report ---
    Route::get('atk/export/excel', [AtkItemController::class, 'exportExcel'])->name('atk.exportExcel');
    Route::get('atk/export/pdf', [AtkItemController::class, 'exportPdf'])->name('atk.exportPdf');

        // --- Barang Masuk & Keluar ---
    Route::get('atk/{atk}/in', [AtkItemController::class, 'stockInForm'])->name('atk.stockin.form');
    Route::post('atk/{atk}/in', [AtkItemController::class, 'stockIn'])->name('atk.stockin');
    Route::get('atk/{atk}/out', [AtkItemController::class, 'stockOutForm'])->name('atk.stockout.form');
    Route::post('atk/{atk}/out', [AtkItemController::class, 'stockOut'])->name('atk.stockout');
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
