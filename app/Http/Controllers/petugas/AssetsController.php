<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Assets;

use App\Models\KelayakanAssets;
use App\Models\User;
use App\Models\Room;
use App\Models\Kategori;
use App\Models\PengajuanPenghapusanAset;
use App\Models\RiwayatPerbaikan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssetsController extends Controller
{
    /** Tampilkan semua aset */
    public function index()
    {
        $assets = Assets::with([
            'KelayakanAssets',
            'Room',
            'laporanKelayakanTerakhir',
            'izinPerbaikanTerakhir',
            'kategori'
        ])->orderBy('nama')->get();
        $assets = Assets::with(['KelayakanAssets', 'laporanKelayakanTerakhir', 'izinPerbaikanTerakhir', 'kategori', 'user','room'])->orderBy('nama')->get();
        return view('pages.petugas.assets.index', compact('assets'));
    }

    /** Form tambah aset */
    public function create()
    {
        $rooms = Room::orderBy('name')->get();
        $kategoriAsetTetap = Kategori::where('tipe', 'aset_tetap')->get();
        $kategoriATK = Kategori::where('tipe', 'atk')->get();
        $kategoris = Kategori::all();
        return view('pages.petugas.assets.create', compact('kategoriAsetTetap', 'kategoriATK', 'kategoris', 'rooms'));
    }

    /** Simpan aset baru */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => [
                'required',
                function ($attr, $val, $fail) {
                    $kategori = Kategori::find($val);
                    if (!$kategori || $kategori->tipe !== 'aset_tetap') {
                        $fail('Kategori tidak valid untuk jenis aset ini.');
                    }
                }
            ],
            'room_id' => 'required|exists:rooms,id',
            'lokasi'=> 'nullable|string|max:255', // ubah dari exists ke string
            'tanggal_perolehan' => 'nullable|date',
            'kondisi' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        // Hitung umur
        $umur = $request->tanggal_perolehan
            ? Carbon::parse($request->tanggal_perolehan)->diffInYears(now())
            : null;
    
        // Create Aset
        $asset = Assets::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'room_id' => $request->room_id,
            'lokasi' => $request->lokasi,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'umur_tahun' => $umur,
            'kondisi' => $request->kondisi,
            'description' => $request->description,
        ]);
    
        // Generate kelayakan otomatis
        $this->syncKelayakanForAsset($asset);
    
        return redirect()->route('assets.index')->with('success', 'Data aset berhasil ditambahkan.');
    }


    public function edit(Assets $asset)
    {
        $kategoriAsetTetap = Kategori::where('tipe', 'aset_tetap')->get();
        return view('pages.petugas.assets.edit', compact('asset', 'kategoriAsetTetap'));
    }

    /** Update aset */
    public function update(Request $request, Assets $asset)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'room_id' => 'required|exists:rooms,id',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_perolehan' => 'nullable|date',
            'kondisi' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->only([
            'nama', 'kategori_id', 'room_id', 'lokasi', 'tanggal_perolehan', 'kondisi', 'description'
        ]));

        $this->syncKelayakanForAsset($asset);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    /** Hapus aset */
    public function destroy(Assets $asset)
    {
        $asset->KelayakanAssets()?->delete();
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil dihapus.');
    }

    /** Sinkronisasi kelayakan aset */
    protected function syncKelayakanForAsset(Assets $asset)
    {
        $umur = $asset->calculateUmur();
        $asset->update(['umur_tahun' => $umur]);

        // Status kelayakan dasar
        $status = $umur <= 2 ? 'Layak' : ($umur <= 4 ? 'Kurang Layak' : 'Tidak Layak');
        $keterangan = match($status) {
            'Layak' => 'Aset dalam kondisi sangat baik.',
            'Kurang Layak' => 'Aset mulai berkurang performanya.',
            'Tidak Layak' => 'Aset sudah tua dan perlu diganti.'
        };

        // Koreksi berdasarkan kondisi fisik
        $kondisi = strtolower($asset->kondisi);
        if ($kondisi === 'baik') {
            $status = 'Layak';
            $keterangan = 'Aset dalam kondisi baik dan berfungsi normal.';
        } elseif ($kondisi === 'cukup') {
            $status = 'Kurang Layak';
            $keterangan = 'Aset masih berfungsi tapi mulai mengalami penurunan.';
        } elseif ($kondisi === 'rusak') {
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

    // ===================== PERBAIKAN =====================

    /** Form perbaikan aset (digabung di index) */
    public function formPerbaikan($id)
    {
        $asset = Assets::findOrFail($id);
        return view('pages.petugas.perbaikan.create', compact('asset'));
    }

    /** Simpan perbaikan aset */
    public function simpanPerbaikan(Request $request, $id)
    {
        $request->validate([
            'tanggal_perbaikan' => 'required|date',
            'description' => 'required|string|max:1000',
            'biaya' => 'nullable|numeric|min:0',
            'diperbaiki_oleh' => 'nullable|string|max:255',
        ]);

        $asset = Assets::findOrFail($id);

        RiwayatPerbaikan::create([
            'asset_id' => $asset->id,
            'tanggal_perbaikan' => $request->tanggal_perbaikan,
            'description' => $request->description,
            'biaya' => $request->biaya ?? 0,
            'diperbaiki_oleh' => $request->diperbaiki_oleh ?? auth()->user()->name,
            'status' => 'in_progress',
        ]);

        $asset->update([
            'kondisi' => 'baik',
            'pernah_diperbaiki' => true,
        ]);

        KelayakanAssets::updateOrCreate(
            ['asset_id' => $asset->id],
            [
                'status_kelayakan' => 'Layak',
                'keterangan' => 'Aset telah diperbaiki dan kembali berfungsi dengan baik.',
            ]
        );

        return redirect()->route('assets.index')->with('success', 'Data perbaikan berhasil disimpan dan status aset diperbarui menjadi Layak.');
    }

    /** Mulai perbaikan (dari tombol approved) */
    public function mulaiPerbaikan($id)
    {
        $asset = Assets::findOrFail($id);
    
        RiwayatPerbaikan::create([
            'asset_id' => $asset->id,
            'tanggal_perbaikan' => now(),
            'description' => 'Perbaikan sedang berlangsung',
            'biaya' => 0,
            'diperbaiki_oleh' => auth()->user()->name,
            'status' => 'in_progress',
        ]);
    
        return redirect()->route('assets.index')->with('success', 'Perbaikan aset dimulai.');
    }

    /** Tandai perbaikan selesai */
    public function selesaikanPerbaikan(RiwayatPerbaikan $riwayat)
    {
        $riwayat->update([
            'status' => 'completed',
            'tanggal_selesai' => now(),
        ]);

        return redirect()->route('assets.index')->with('success', 'Perbaikan aset selesai.');
    }

    /** Kirim ke kepdin setelah selesai */
    public function kirimKeKepdin(RiwayatPerbaikan $riwayat)
    {
        $riwayat->update([
            'status' => 'final_approved', 
        ]);

        return redirect()->route('assets.index')->with('success', 'Perbaikan aset telah dikirim ke Kepdin.');
    }

    // ===================== PENGAJUAN HAPUS =====================

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

        return redirect()->route('assets.index')->with('success', 'Pengajuan penghapusan telah dikirim ke Kepdin.');
    }
}
