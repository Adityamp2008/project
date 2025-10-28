<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\KelayakanAssets; 
use App\Models\User;
use App\Models\PengajuanPenghapusanAset;
use App\Models\RiwayatPerbaikan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssetsController extends Controller
{
    public function index()
    {
        $assets = Assets::with(['KelayakanAssets', 'laporanKelayakanTerakhir', 'izinPerbaikanTerakhir'])->orderBy('nama')->get();
        return view('pages.petugas.assets.index', compact('assets'));
    }
    

    public function create()
    {
        return view('pages.petugas.assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'kondisi' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $asset = Assets::create($request->only([
            'nama', 'kategori', 'lokasi', 'tanggal_perolehan', 'kondisi', 'description'
        ]));

        $this->syncKelayakanForAsset($asset);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil ditambahkan.');
    }

    public function edit(Assets $asset)
    {
        return view('pages.petugas.assets.edit', compact('asset'));
    }

    public function update(Request $request, Assets $asset)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'kondisi' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->only([
            'nama', 'kategori', 'lokasi', 'tanggal_perolehan', 'kondisi', 'description'
        ]));

        $this->syncKelayakanForAsset($asset);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Assets $asset)
    {
        $asset->KelayakanAssets()?->delete(); // hapus relasi juga
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil dihapus.');
    }

    /**
     * Tentukan kelayakan berdasarkan umur & kondisi
     */
    protected function syncKelayakanForAsset(Assets $asset)
    {
        $umur = $asset->calculateUmur();
        $asset->update(['umur_tahun' => $umur]);

        // Hitung status kelayakan berdasarkan umur
        if ($umur <= 2) {
            $status = 'Layak';
            $keterangan = 'Aset dalam kondisi sangat baik.';
        } elseif ($umur <= 4) {
            $status = 'Kurang Layak';
            $keterangan = 'Aset mulai berkurang performanya.';
        } else {
            $status = 'Tidak Layak';
            $keterangan = 'Aset sudah tua dan perlu diganti.';
        }

        // Sesuaikan kondisi manual jika rusak
        if (strtolower($asset->kondisi) === 'rusak') {
            $status = 'Tidak Layak';
            $keterangan = 'Aset rusak dan tidak berfungsi.';
        }

        KelayakanAssets::updateOrCreate(
            ['asset_id' => $asset->id],
            [
                'status_kelayakan' => $status,
                'keterangan' => $keterangan,
            ]
        );
    }

    public function formPerbaikan($id)
{
    $asset = Assets::findOrFail($id);
    return view('pages.petugas.perbaikan.create', compact('asset'));
}

/**
 * Simpan data perbaikan ke tabel riwayat_perbaikan
 */
    public function simpanPerbaikan(Request $request, $id)
    {
        $request->validate([
            'tanggal_perbaikan' => 'required|date',
            'deskripsi' => 'required|string|max:1000',
            'biaya' => 'nullable|numeric|min:0',
            'diperbaiki_oleh' => 'nullable|string|max:255',
        ]);

        $asset = Assets::findOrFail($id);

        RiwayatPerbaikan::create([
            'asset_id' => $asset->id,
            'tanggal_perbaikan' => $request->tanggal_perbaikan,
            'deskripsi' => $request->deskripsi,
            'biaya' => $request->biaya ?? 0,
            'diperbaiki_oleh' => $request->diperbaiki_oleh ?? (auth()->user()->name ?? 'Petugas'),
        ]);

        $asset->update([
            'kondisi' => 'baik',
            'pernah_diperbaiki' => true,
        ]);

        // Update kelayakan jadi Layak
        KelayakanAssets::updateOrCreate(
            ['asset_id' => $asset->id],
            [
                'status_kelayakan' => 'Layak',
                'keterangan' => 'Aset telah diperbaiki dan kembali berfungsi dengan baik.',
            ]
        );

        return redirect()->route('assets.index')->with('success', 'Data perbaikan berhasil disimpan dan status aset diperbarui menjadi Layak.');
    }
    
    public function formHapus($id)
    {
        $asset = Assets::findOrFail($id);
        return view('pages.petugas.assets.formHapus', compact('asset'));
    }
    
    public function ajukanHapus(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:5',
        ]);
    
        $asset = Assets::findOrFail($id);
    
        PengajuanPenghapusanAset::create([
            'asset_id' => $id,
            'diajukan_oleh' => auth()->user()->name ?? 'Petugas Tidak Dikenal',
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);
    
        return redirect()->route('assets.index')->with('success', 'Pengajuan penghapusan telah dikirim ke Kepdin untuk ditinjau.');
    }
}
