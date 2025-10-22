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
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $asset = Assets::create($request->only([
            'nama', 'kategori', 'lokasi', 'tanggal_perolehan', 'description'
        ]));

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
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->only([
            'nama', 'kategori', 'lokasi', 'tanggal_perolehan', 'description'
        ]));

        $this->syncKelayakanForAsset($asset);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Assets $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Data aset berhasil dihapus.');
    }

    /**
     * Hitung otomatis umur, kondisi, dan kelayakan
     */
    protected function syncKelayakanForAsset(Assets $asset)
    {
        $umur = $asset->tanggal_perolehan
            ? Carbon::parse($asset->tanggal_perolehan)->diffInYears(now())
            : 0;

        if ($umur >= 0 && $umur <= 1) {
            $kondisi = 'Baik';
            $status = 'Layak';
            $keterangan = 'Aset masih baru dan berfungsi baik.';
        } elseif ($umur >= 2 && $umur <= 3) {
            $kondisi = 'Cukup';
            $status = 'Kurang Layak';
            $keterangan = 'Aset mulai menurun, perlu perhatian.';
        } else {
            $kondisi = 'Rusak';
            $status = 'Tidak Layak';
            $keterangan = 'Aset sudah tua dan perlu diganti.';
        }

        $asset->update([
            'umur_tahun' => $umur,
            'kondisi' => $kondisi,
            'kelayakan' => $status,
        ]);

        KelayakanAssets::updateOrCreate(
            ['asset_id' => $asset->id],
            [
                'status_kelayakan' => $status,
                'keterangan' => $keterangan
            ]
        );
    }
}
