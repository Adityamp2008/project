<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\assets;
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
        $assetss = assets::all();
        return view('riwayat.create', compact('assetss'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assets_id' => 'required|exists:assetss,id',
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
        $assetss = assets::all();
        return view('riwayat.edit', compact('riwayat', 'assetss'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Riwayat $riwayat)
    {
        $request->validate([
            'assets_id' => 'required|exists:assetss,id',
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
        return back()->with('success', 'Riwayat berhasil dihapus.');
    }
}
