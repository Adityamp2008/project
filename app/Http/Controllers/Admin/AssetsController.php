<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with(['kategori', 'kondisi', 'lokasi', 'riwayat'])->get();
        return view('aset.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $lokasis = Lokasi::all();
        return view('aset.create', compact('kategoris', 'kondisis', 'lokasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi_id' => 'required|exists:kondisis,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'tanggal_perolehan' => 'required|date',
        ]);

        Aset::create($request->all());

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Assets $assets)
    {
        $aset->load('riwayat', 'kategori', 'kondisi', 'lokasi');
        return view('aset.show', compact('aset'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assets $assets)
    {
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $lokasis = Lokasi::all();
        return view('aset.edit', compact('aset', 'kategoris', 'kondisis', 'lokasis'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assets $assets)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi_id' => 'required|exists:kondisis,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'tanggal_perolehan' => 'required|date',
        ]);

        $aset->update($request->all());

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Aset $aset)
    {
        $aset->delete();
        return redirect()->route('aset.index')->with('success', 'Data aset berhasil dihapus.');
    }
}
