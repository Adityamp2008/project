<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockTransactionsExport implements FromCollection, WithHeadings
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($trx) {
            return [
                'Tanggal' => $trx->created_at->format('d/m/Y H:i'),
                'Nama Barang' => $trx->item->name ?? '-',
                'Jenis' => $trx->type === 'in' ? 'Masuk' : 'Keluar',
                'Jumlah' => $trx->quantity,
                'Keterangan' => $trx->reference ?? '-',
                'Pengguna' => $trx->user->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Nama Barang', 'Jenis', 'Jumlah', 'Keterangan', 'Pengguna'];
    }
}
