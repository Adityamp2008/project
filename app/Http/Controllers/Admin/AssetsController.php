<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data aset tanpa relasi
        $assets = Assets::all();
        return view('pages.admin.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak perlu kirim data relasi karena input manual
        return view('pages.admin.assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kondisi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_perolehan' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Assets::create($request->all());

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assets $asset)
    {
        return view('pages.admin.assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assets $asset)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kondisi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_perolehan' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->all());

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assets $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Data aset berhasil dihapus.');
    }
}
