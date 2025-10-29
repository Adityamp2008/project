<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('pages.admin.kategori.index', compact('kategoris'));
    }

    // Form tambah
    public function create()
    {
        return view('pages.admin.kategori.create');
    }

    // Simpan kategori
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:aset_tetap,atk',
        ]);

        Kategori::create($request->only(['nama', 'tipe']));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Form edit
    public function edit(Kategori $kategori)
    {
        return view('pages.admin.kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:aset_tetap,atk',
        ]);

        $kategori->update($request->only(['nama', 'tipe']));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // Hapus kategori
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
