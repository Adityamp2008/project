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
        $riwayats = Riwayat::with('aset')->latest()->get();
        return view('riwayat.index', compact('riwayats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $asets = Aset::all();
        return view('riwayat.create', compact('asets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
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
        $riwayat->load('aset');
        return view('riwayat.show', compact('riwayat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Riwayat $riwayat)
    {
        $asets = Aset::all();
        return view('riwayat.edit', compact('riwayat', 'asets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Riwayat $riwayat)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
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
