<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kondisi;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kondisis = Kondisi::all();
        return view('kondisi.index', compact('kondisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kondisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Kondisi::create($request->only(['nama', 'deskripsi']));

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kondisi $kondisi)
    {
        return view('kondisi.edit', compact('kondisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kondisi $kondisi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kondisi->update($request->only(['nama', 'deskripsi']));

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kondisi $kondisi)
    {
        $kondisi->delete();
        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil dihapus.');
    }
}
