<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    UserController,
    KategoriController
    
    
};
use App\Http\Controllers\petugas\{
    DashboardController as PetugasDashboard,
    AssetsController,
    AtkItemController,
    KelayakanAssetsController,
    RiwayatPerbaikanController
    
};
use App\Http\Controllers\kepdin\{
    DashboardController as KepdinDashboard,
    LaporanKelayakanController,
    KepdinController,
    KepdinAtkController,
    LaporanInventarisController,
    LaporanPerbaikanController,
    LaporanAtkController,
    PengajuanStokController
    
};


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

    Route::post('/users/import', [App\Http\Controllers\Admin\UserController::class, 'import'])->name('users.import');

    
   

    Route::get('admin/riwayat-perbaikan', [RiwayatPerbaikanController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat-perbaikan/create', [RiwayatPerbaikanController::class, 'create'])->name('riwayat.create');
    Route::post('/riwayat-perbaikan', [RiwayatPerbaikanController::class, 'store'])->name('riwayat.store');
    Route::get('/get-items/{type}', [RiwayatPerbaikanController::class, 'getItems'])->name('get.items');
    
    
        Route::resource('kategori', KategoriController::class);


    //Laporan perbaikan
// LAPORAN PERBAIKAN


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
    Route::post('/kelayakanassets/{id}/laporkan', [KelayakanAssetsController::class, 'laporkan'])->name('kelayakanassets.laporkan');

    
    // --- Export / Report ---
    Route::get('atk/export/excel', [AtkItemController::class, 'exportExcel'])->name('atk.exportExcel');
    Route::get('atk/export/pdf', [AtkItemController::class, 'exportPdf'])->name('atk.exportPdf');

        // --- Barang Masuk & Keluar ---
    Route::get('atk/{atk}/in', [AtkItemController::class, 'stockInForm'])->name('atk.stockin.form');
    Route::post('atk/{atk}/in', [AtkItemController::class, 'stockIn'])->name('atk.stockin');
    Route::get('atk/{atk}/out', [AtkItemController::class, 'stockOutForm'])->name('atk.stockout.form');
    Route::post('atk/{atk}/out', [AtkItemController::class, 'stockOut'])->name('atk.stockout');
    
    Route::get('/perbaikan/{asset}/create', [RiwayatPerbaikanController::class, 'create'])->name('perbaikan.create');
    Route::post('/perbaikan/{asset}', [RiwayatPerbaikanController::class, 'store'])->name('perbaikan.store');
    
    Route::get('/assets/{id}/perbaikan', [AssetsController::class, 'formPerbaikan'])
        ->name('assets.formPerbaikan');
    
    // Proses Simpan Perbaikan
    Route::post('/assets/{id}/perbaikan', [AssetsController::class, 'simpanPerbaikan'])
        ->name('assets.simpanPerbaikan');
        
        Route::get('/riwayat-perbaikan', [RiwayatPerbaikanController::class, 'index'])
            ->name('riwayat-perbaikan.index');
            
            Route::get('/assets/hapus/{id}', [AssetsController::class, 'formHapus'])->name('assets.formHapus');
            Route::post('/assets/hapus/{id}', [AssetsController::class, 'ajukanHapus'])->name('assets.ajukanHapus');
            
            Route::post('/atk/{atk}/ajukan-hapus', [AtkItemController::class, 'ajukanHapus'])->name('atk.ajukanHapus');
});


// =================================================
// ============== KEPALA DINAS ROUTE ===============
// =================================================
Route::group([
    'prefix' => 'kepdin',
    'middleware' => ['auth', 'role:kepdin']
], function() {
    Route::get('/dashboard', [KepdinDashboard::class, 'index'])->name('kepdin.dashboard');
        
    Route::get('/laporan-kelayakan', [LaporanKelayakanController::class, 'index'])->name('kepdin.laporan.index');
    Route::post('/laporan-kelayakan/{id}/approve', [LaporanKelayakanController::class, 'approve'])->name('kepdin.laporan.approve');
    Route::post('/laporan-kelayakan/{id}/reject', [LaporanKelayakanController::class, 'reject'])->name('kepdin.laporan.reject');
    
    Route::get('/kepdin/penghapusan', [KepdinController::class, 'indexPenghapusan'])->name('kepdin.penghapusan.index');
    Route::post('/penghapusan/{id}/setujui', [KepdinController::class, 'setujuiHapus'])->name('kepdin.penghapusan.setujui');
    Route::post('/penghapusan/{id}/tolak', [KepdinController::class, 'tolakHapus'])->name('kepdin.penghapusan.tolak');
    
    Route::get('penghapusan-atk', [KepdinAtkController::class, 'index'])->name('penghapusan_atk.index');
    Route::post('/penghapusan-atk/{id}/setujui', [KepdinAtkController::class, 'setujui'])->name('penghapusan_atk.setujui');
    Route::post('/penghapusan-atk/{id}/tolak', [KepdinAtkController::class, 'tolak'])->name('penghapusan_atk.tolak');

          // Laporan Inventaris
Route::get('laporan/inventaris', [LaporanInventarisController::class, 'index'])->name('laporan.inventaris');
Route::get('laporan/inventaris/pdf', [LaporanInventarisController::class, 'pdf'])->name('laporan.inventaris.pdf');
Route::get('laporan/inventaris/excel', [LaporanInventarisController::class, 'excel'])->name('laporan.inventaris.excel');

//laporan perbaikan
Route::get('laporan/perbaikan', [LaporanPerbaikanController::class, 'laporan'])->name('laporan.perbaikan');
Route::get('laporan/perbaikan/pdf', [LaporanPerbaikanController::class, 'laporanPdf'])->name('laporan.perbaikan.pdf');
Route::get('laporan/perbaikan/excel', [LaporanPerbaikanController::class, 'laporanExcel'])->name('laporan.perbaikan.excel');

 // --- Laporan atk ---
    Route::get('laporan/report', [LaporanAtkController::class, 'report'])->name('laporan.report');
    Route::get('laporan/report/pdf', [LaporanAtkController::class, 'reportPdf'])->name('laporan.report.pdf');
    Route::get('laporan/report/excel', [LaporanAtkController::class, 'exportExcel'])->name('laporan.report.excel');

    // routes/kepdin.php
Route::get('pengajuan-stok', [PengajuanStokController::class, 'index'])->name('kepdin.pengajuan.index');
Route::post('pengajuan-stok/{pengajuan}/setujui', [PengajuanStokController::class, 'setujui'])->name('kepdin.pengajuan.setujui');
Route::post('pengajuan-stok/{pengajuan}/tolak', [PengajuanStokController::class, 'tolak'])->name('kepdin.pengajuan.tolak');

Route::get('/kepdin/pengajuan/pdf', [PengajuanStokController::class, 'pengajuanPdf'])->name('kepdin.pengajuan.pdf');

    
});


require __DIR__.'/auth.php';
