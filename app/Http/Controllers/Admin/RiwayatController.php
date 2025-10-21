<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayats = Riwayat::with('assets')->latest()->get();
        return view('riwayat.index', compact('riwayats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Assets::all();
        return view('riwayat.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assets_id' => 'required|exists:assets,id',
            'tipe' => 'required|in:penggunaan,perbaikan',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        Riwayat::create($request->all());

        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Riwayat $riwayat)
    {
        $riwayat->load('assets');
        return view('riwayat.show', compact('riwayat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Riwayat $riwayat)
    {
        $assets = Assets::all();
        return view('riwayat.edit', compact('riwayat', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Riwayat $riwayat)
    {
        $request->validate([
            'assets_id' => 'required|exists:assets,id',
            'tipe' => 'required|in:penggunaan,perbaikan',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $riwayat->update($request->all());

        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Riwayat $riwayat)
    {
        $riwayat->delete();
        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil dihapus.');
    }
}
