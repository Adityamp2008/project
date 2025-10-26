<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use App\Models\PengajuanPenghapusanAset;
use App\Models\LaporanKelayakan;

class KepdinController extends Controller
{
    public function indexPenghapusan()
    {
        $pengajuan = PengajuanPenghapusanAset::with('asset')->latest()->get();
        return view('pages.kepdin.penghapusan.index', compact('pengajuan'));
    }
    
    public function setujuiHapus($id)
    {
        $pengajuan = PengajuanPenghapusanAset::with('asset')->findOrFail($id);

        // Ubah status pengajuan
        $pengajuan->update(['status' => 'disetujui']);

        // Hapus aset terkait
        if ($pengajuan->asset) {
            $pengajuan->asset->delete();
        }

        return back()->with('success', '✅ Aset "' . $pengajuan->asset->nama . '" telah disetujui untuk dihapus.');
    }
    
    public function tolakHapus($id)
    {
        $pengajuan = PengajuanPenghapusanAset::findOrFail($id);
        $pengajuan->update(['status' => 'ditolak']);

        // (opsional) bisa tambahkan notifikasi ke dashboard petugas
        return back()->with('error', '❌ Pengajuan penghapusan aset "' . $pengajuan->asset->nama . '" telah ditolak.');
    }
}
