<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\PenghapusanAtk;
use App\Models\AtkItem;
use Illuminate\Http\Request;

class KepdinAtkController extends Controller
{
    /**
     * Menampilkan daftar pengajuan penghapusan ATK
     */
    public function index()
    {
        // Ambil semua data penghapusan dengan relasi item & user
        $penghapusan = PenghapusanAtk::with(['item', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.kepdin.penghapusan_atk.index', compact('penghapusan'));
    }

    /**
     * Menyetujui penghapusan ATK dan menghapus item-nya dari tabel AtkItem
     */
    public function setujui($id)
    {
        $penghapusan = PenghapusanAtk::with('item')->findOrFail($id);

        // Pastikan item masih ada
        if ($penghapusan->item) {
            $penghapusan->item->delete();
        }

        // Update status
        $penghapusan->update(['status' => 'disetujui']);

        return redirect()->back()->with('success', 'Penghapusan data disetujui dan item telah dihapus.');
    }

    /**
     * Menolak penghapusan ATK
     */
    public function tolak($id, Request $request)
    {
        $penghapusan = PenghapusanAtk::findOrFail($id);

        $penghapusan->update([
            'status' => 'ditolak',
        ]);

        return redirect()->back()->with('error', 'Penghapusan data ditolak.');
    }
}
