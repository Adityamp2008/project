<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\RiwayatPerbaikan;
use Illuminate\Http\Request;

class RiwayatPerbaikanController extends Controller
{
    
    public function index()
    {
        // Ambil semua data perbaikan dengan relasi aset
        $riwayats = RiwayatPerbaikan::with('asset')->latest()->get();

        return view('pages.petugas.riwayat_perbaikan.index', compact('riwayats'));
    }
    
    /**
     * Form tambah perbaikan
     */
    public function create(Assets $asset)
    {
        return view('pages.petugas.perbaikan.create', compact('asset'));
    }

    /**
     * Simpan ke database
     */
    public function store(Request $request, Assets $asset)
    {
        $request->validate([
            'deskripsi_perbaikan' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'diperbaiki_oleh' => 'required|string|max:255',
        ]);

        RiwayatPerbaikan::create([
            'asset_id' => $asset->id,
            'deskripsi_perbaikan' => $request->deskripsi_perbaikan,
            'biaya' => $request->biaya,
            'diperbaiki_oleh' => $request->diperbaiki_oleh,
            'tanggal_perbaikan' => now(),
        ]);

        return redirect()->route('assets.index')->with('success', 'Perbaikan berhasil dicatat.');
    }
}
