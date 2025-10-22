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
            'kondisi' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $asset = Assets::create($request->only([
            'nama','kategori','lokasi','tanggal_perolehan','kondisi','description'
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
            'kondisi' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->only([
            'nama','kategori','lokasi','tanggal_perolehan','kondisi','description'
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
     * Tentukan kelayakan berdasarkan kondisi aset
     */
    protected function syncKelayakanForAsset(Assets $asset)
    {
        $umur = $asset->tanggal_perolehan
            ? Carbon::parse($asset->tanggal_perolehan)->diffInYears(now())
            : 0;

        $status = 'Tidak Diketahui';
        $keterangan = '';

        switch (strtolower($asset->kondisi)) {
            case 'baik':
                $status = 'Layak';
                $keterangan = 'Aset masih berfungsi dengan baik.';
                break;

            case 'cukup':
                $status = 'Kurang Layak';
                $keterangan = 'Aset mulai berkurang performanya.';
                break;

            case 'rusak':
                $status = 'Tidak Layak';
                $keterangan = 'Aset tidak dapat digunakan, perlu diganti.';
                break;

            default:
                $status = 'Tidak Diketahui';
                $keterangan = 'Kondisi aset belum ditentukan.';
        }

        // Update umur aset di tabel
        $asset->update(['umur_tahun' => $umur]);

        // Simpan status kelayakan otomatis
        KelayakanAssets::updateOrCreate(
            ['asset_id' => $asset->id],
            [
                'status_kelayakan' => $status,
                'keterangan' => $keterangan,
            ]
        );
    }
}
    