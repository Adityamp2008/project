<?php

namespace App\Http\Controllers\Admin;

use App\Models\AtkItem;
use App\Models\AtkUsage;
use App\Models\StockTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // jika pake maatwebsite/excel
use PDF; // jika pake barryvdh/laravel-dompdf

class AtkItemController extends Controller
{
    public function index(Request $req) {
        $items = AtkItem::query()
            ->when($req->search, fn($q)=>$q->where('name','like','%'.$req->search.'%'))
            ->paginate(15);
        return view('pages.admin.atk.index', compact('items'));
    }

     public function create()
{
    // ambil kode terakhir
    $lastCode = AtkItem::orderBy('id', 'desc')->value('code');

    if ($lastCode) {
        // ambil angka dari kode terakhir, misal: ID-005 -> 5
        $num = (int) str_replace('ID-', '', $lastCode) + 1;
    } else {
        $num = 1;
    }

    // format jadi ID-001, ID-002, dst
    $newCode = 'ID-' . str_pad($num, 3, '0', STR_PAD_LEFT);

    // kirim ke view
    return view('pages.admin.atk.create', compact('newCode'));
}

public function store(Request $r)
{
    $r->validate([
        'name'=>'required',
        'stock'=>'nullable|integer|min:0',
    ]);

    // generate ulang (supaya aman kalau ada request lain)
    $lastCode = AtkItem::orderBy('id', 'desc')->value('code');
    if ($lastCode) {
        $num = (int) str_replace('ID-', '', $lastCode) + 1;
    } else {
        $num = 1;
    }
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


     public function edit(AtkItem $atk)
     {
         return view('pages.admin.atk.edit', compact('atk')); 
     }

      public function update(Request $r, AtkItem $atk){
        $r->validate(['name'=>'required']);
        $atk->update($r->only(['name','description','unit','low_stock_threshold','category','active']));
        return back()->with('success','Diupdate');
    }

    public function destroy(AtkItem $atk){
        $atk->delete();
        return back()->with('success','Dihapus');
    }

    // STOCK OUT (pemakaian)
    public function stockOut(Request $r, AtkItem $atk){
        $r->validate(['quantity'=>'required|integer|min:1']);
        $qty = (int) $r->quantity;
        if ($atk->stock < $qty) return back()->withErrors('Stok tidak cukup');
        $atk->decrement('stock', $qty);
        StockTransaction::create([
            'atk_item_id'=>$atk->id,'type'=>'out','quantity'=>$qty,
            'reference'=>$r->reference,'user_id'=>auth()->id()
        ]);
        // optional: catat pemakaian per pegawai
        if ($r->filled('used_by')) {
            AtkUsage::create(['atk_item_id'=>$atk->id,'user_id'=>$r->used_by,'quantity'=>$qty,'note'=>$r->note]);
        }
        return back()->with('success','Stok dikurangi');
    }

    // LAPORAN sederhana (filter by date, item, category)
    public function report(Request $r){
        $from = $r->from ?: now()->subMonth()->format('Y-m-d');
        $to = $r->to ?: now()->format('Y-m-d');
        $transactions = StockTransaction::with('item')
            ->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->orderBy('created_at','desc')
            ->get();
        return view('atk.report', compact('transactions','from','to'));
    }

    // EXPORT EXCEL (contoh sederhana)
    public function exportExcel(Request $r){
        $items = AtkItem::all();
        // gunakan maatwebsite/excel -> pembuatan export class lebih rapi, ini contoh cepat:
        return Excel::download(new \App\Exports\AtkItemsExport($items), 'atk_items.xlsx');
    }

     // EXPORT PDF
    public function exportPdf(Request $r){
        $items = AtkItem::all();
        $pdf = PDF::loadView('atk.pdf_items', compact('items'));
        return $pdf->download('atk_items.pdf');
    }

}
