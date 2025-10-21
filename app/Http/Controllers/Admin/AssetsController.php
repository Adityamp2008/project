<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\KelayakanAssets;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssetsController extends Controller
{
    public function index()
    {
        $assets = Assets::orderBy('nama')->get();
        return view('pages.admin.assets.index', compact('assets'));
    }

    public function create()
    {
        return view('pages.admin.assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $asset = Assets::create($request->only([
            'nama','kategori','kondisi','lokasi','tanggal_perolehan','description'
        ]));

        // langsung hitung umur dan kelayakan otomatis
        $this->syncKelayakanForAsset($asset);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil ditambahkan.');
    }

    public function edit(Assets $asset)
    {
        return view('pages.admin.assets.edit', compact('asset'));
    }

    public function update(Request $request, Assets $asset)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->only([
            'nama','kategori','kondisi','lokasi','tanggal_perolehan','description'
        ]));

        // update umur (booted akan set saat updating) and update kelayakan
        $this->syncKelayakanForAsset($asset);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Assets $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Data aset berhasil dihapus.');
    }

    /**
     * Hitung & simpan kelayakan untuk 1 asset
     */
    protected function syncKelayakanForAsset(Assets $asset)
    {
        // pastikan umur_tahun sudah ter-update (booted hook)
        $umur = $asset->umur_tahun ?? ( $asset->tanggal_perolehan ? Carbon::parse($asset->tanggal_perolehan)->diffInYears(now()) : 0 );

        $kondisi = strtolower($asset->kondisi ?? '');

        $status = 'Tidak Diketahui';
        $keterangan = '';

        // LOGIKA contoh (bisa disesuaikan)
        if ($kondisi === 'baik' && $umur <= 5) {
            $status = 'Layak';
            $keterangan = 'Aset masih berfungsi baik, usia <= 5 tahun.';
        } elseif ($kondisi === 'rusak ringan' || ($umur > 5 && $umur <= 8)) {
            $status = 'Kurang Layak';
            $keterangan = 'Perlu perawatan; kondisi atau usia mengindikasikan menurun.';
        } elseif ($kondisi === 'rusak berat' || $umur > 8) {
            $status = 'Tidak Layak';
            $keterangan = 'Tidak layak pakai, pertimbangkan penggantian.';
        }

        KelayakanAssets::updateOrCreate(
            ['asset_id' => $asset->id],
            ['status_kelayakan' => $status, 'keterangan' => $keterangan]
        );
    }
}
