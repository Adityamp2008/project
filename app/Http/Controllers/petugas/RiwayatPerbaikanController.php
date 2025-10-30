<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\Kategori;
use App\Models\RiwayatPerbaikan;
use Illuminate\Http\Request;

class RiwayatPerbaikanController extends Controller
{
    /**
     * Tampilkan semua riwayat perbaikan yang sudah diizinkan
     * dengan filter kategori & petugas.
     */
    public function index(Request $request)
    {
        $kategori = Kategori::all();

        $riwayat = RiwayatPerbaikan::with('asset')
            ->when($request->filled('kategori'), fn($q) => 
                $q->whereHas('asset.kategori', fn($q2) => $q2->where('id', $request->kategori))
            )
            ->when($request->filled('diperbaiki_oleh'), fn($q) => 
                $q->where('diperbaiki_oleh', 'like', "%{$request->diperbaiki_oleh}%")
            )
            ->get(); // ambil semua tanpa pagination

        return view('pages.petugas.riwayat_perbaikan.index', compact('riwayat', 'kategori'));
    }

    /**
     * Form tambah perbaikan aset
     */
    public function create(Assets $asset)
    {
        return view('pages.petugas.perbaikan.create', compact('asset'));
    }

    /**
     * Simpan perbaikan baru
     */
    public function store(Request $request, Assets $asset)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'diperbaiki_oleh' => 'required|string|max:255',
            'tanggal_perbaikan' => 'required|date',
        ]);

        RiwayatPerbaikan::create([
            'asset_id' => $asset->id,
            'deskripsi' => $request->deskripsi,
            'biaya' => $request->biaya,
            'diperbaiki_oleh' => auth()->user()->name,
            'tanggal_perbaikan' => $request->tanggal_perbaikan,
            'status' => 'proses',
        ]);

        return redirect()->route('assets.index')
            ->with('success', 'Perbaikan aset berhasil dicatat.');
    }

    /**
     * Tandai perbaikan selesai
     */
    public function selesai(RiwayatPerbaikan $riwayat)
    {
        $riwayat->update([
            'status' => 'selesai',
            'tanggal_selesai' => now(),
        ]);

        return redirect()->route('riwayat-perbaikan.index')
            ->with('success', 'Perbaikan berhasil ditandai selesai.');
    }
}
