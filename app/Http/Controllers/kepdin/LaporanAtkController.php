<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\AtkItem;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\AtkItemsExport;

class LaporanAtkController extends Controller
{
    /**
     * Tampilkan halaman laporan transaksi ATK (barang masuk/keluar)
     */
    public function report(Request $r)
    {
        $from = $r->from ?: now()->subMonth()->format('Y-m-d');
        $to = $r->to ?: now()->format('Y-m-d');

        $transactions = StockTransaction::with(['item', 'user'])
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->when($r->search, function ($q) use ($r) {
                $q->whereHas('item', fn($qq) => $qq->where('name', 'like', '%' . $r->search . '%'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pages.kepdin.laporan.report', compact('transactions', 'from', 'to'));
    }

    /**
     * Export laporan ke Excel
     */
    public function reportExcel(Request $r)
    {
        $items = AtkItem::all();
        return Excel::download(new AtkItemsExport($items), 'laporan_atk.xlsx');
    }

    /**
     * Export laporan ke PDF
     */
    public function reportPdf(Request $r)
    {
        $from = $r->from ?: now()->subMonth()->format('Y-m-d');
        $to = $r->to ?: now()->format('Y-m-d');

        $transactions = StockTransaction::with(['item', 'user'])
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->when($r->search, function ($q) use ($r) {
                $q->whereHas('item', fn($qq) => $qq->where('name', 'like', '%' . $r->search . '%'));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('pages.pkepdin.laporan.reportpdf', compact('transactions', 'from', 'to'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_stok_atk.pdf');
    }
}
