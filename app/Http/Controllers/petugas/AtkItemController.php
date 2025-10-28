<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\AtkItem;
use App\Models\PengajuanStokAtk;
use App\Models\PenghapusanAtk;
use Illuminate\Http\Request;

class AtkItemController extends Controller
{
    /** ===============================
     *  LIST ITEM
     *  =============================== */
    public function index(Request $req)
    {
        $items = AtkItem::query()
            ->when($req->search, fn($q) =>
                $q->where('name', 'like', '%' . $req->search . '%')
            )
            ->paginate(15);

        return view('pages.petugas.atk.index', compact('items'));
    }

    /** ===============================
     *  FORM TAMBAH ITEM
     *  =============================== */
    public function create()
    {
        $lastCode = AtkItem::orderBy('id', 'desc')->value('code');
        $num = $lastCode ? ((int) str_replace('ID-', '', $lastCode) + 1) : 1;
        $newCode = 'ID-' . str_pad($num, 3, '0', STR_PAD_LEFT);

        return view('pages.petugas.atk.create', compact('newCode'));
    }

    /** ===============================
     *  SIMPAN ITEM BARU
     *  =============================== */
    public function store(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'stock' => 'nullable|integer|min:0',
        ]);

        $lastCode = AtkItem::orderBy('id', 'desc')->value('code');
        $num = $lastCode ? ((int) str_replace('ID-', '', $lastCode) + 1) : 1;
        $code = 'ID-' . str_pad($num, 3, '0', STR_PAD_LEFT);

        AtkItem::create([
            'code' => $code,
            'name' => $r->name,
            'description' => $r->description,
            'unit' => $r->unit,
            'stock' => $r->stock ?? 0,
            'low_stock_threshold' => $r->low_stock_threshold,
            'category' => $r->category,
        ]);

        return redirect()->route('atk.index')->with('success', 'Item baru berhasil dibuat!');
    }

    /** ===============================
     *  EDIT ITEM
     *  =============================== */
    public function edit(AtkItem $atk)
    {
        return view('pages.petugas.atk.edit', compact('atk'));
    }

    public function update(Request $r, AtkItem $atk)
    {
        $r->validate(['name' => 'required']);
        $atk->update($r->only(['name', 'description', 'unit', 'low_stock_threshold', 'category', 'active']));
        return back()->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(AtkItem $atk)
    {
        $atk->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }

    /** ===============================
     *  AJUKAN PENAMBAHAN STOK
     *  =============================== */
    public function stockInForm(AtkItem $atk)
    {
        return view('pages.petugas.atk.stock_in', compact('atk'));
    }

    public function stockIn(Request $r, AtkItem $atk)
    {
        $r->validate([
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:100'
        ]);

        // Simpan ke tabel pengajuan stok (belum langsung ubah stok)
        PengajuanStokAtk::create([
            'atk_item_id' => $atk->id,
            'jenis' => 'in',
            'jumlah' => $r->quantity,
            'keterangan' => $r->reference,
            'user_id' => auth()->id(),
            'status' => 'menunggu'
        ]);

        return redirect()->route('atk.index')->with('success', 'Pengajuan penambahan stok dikirim ke kepala dinas.');
    }

    /** ===============================
     *  AJUKAN PENGURANGAN STOK
     *  =============================== */
    public function stockOutForm(AtkItem $atk)
    {
        return view('pages.petugas.atk.stock_out', compact('atk'));
    }

    public function stockOut(Request $r, AtkItem $atk)
    {
        $r->validate([
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        PengajuanStokAtk::create([
            'atk_item_id' => $atk->id,
            'jenis' => 'out',
            'jumlah' => $r->quantity,
            'keterangan' => $r->reference,
            'user_id' => auth()->id(),
            'status' => 'menunggu'
        ]);

        return redirect()->route('atk.index')->with('success', 'Pengajuan pengurangan stok dikirim ke kepala dinas.');
    }

    /** ===============================
     *  AJUKAN PENGHAPUSAN ITEM
     *  =============================== */
    public function ajukanHapus(Request $r, AtkItem $atk)
    {
        $r->validate(['alasan' => 'required|string|min:5']);

        PenghapusanAtk::create([
            'atk_item_id' => $atk->id,
            'user_id' => auth()->id(),
            'alasan' => $r->alasan,
            'status' => 'menunggu'
        ]);

        return redirect()->route('atk.index')->with('success', 'Pengajuan penghapusan item dikirim ke kepala dinas.');
    }
}
