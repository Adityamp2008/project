<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
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
        $assets = Assets::with(['kategori', 'kondisi', 'lokasi', 'riwayat'])->get();
        return view('pages.admin.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $lokasis = Lokasi::all();
        return view('pages.admin.assets.create', compact('kategoris', 'kondisis', 'lokasis'));
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

        assets::create($request->all());

        return redirect()->route('pages.admin.assets.index')->with('success', 'Data assets berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Assets $assets)
    {
        $assets->load('riwayat', 'kategori', 'kondisi', 'lokasi');
        return view('pages.admin.assets.show', compact('assets'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assets $assets)
    {
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $lokasis = Lokasi::all();
        return view('pages.admin.assets.edit', compact('assets', 'kategoris', 'kondisis', 'lokasis'));
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

        $assets->update($request->all());

        return redirect()->route('pages.admin.assets.index')->with('success', 'Data assets berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(assets $assets)
    {
        $assets->delete();
        return redirect()->route('pages.admin.assets.index')->with('success', 'Data assets berhasil dihapus.');
    }
}
