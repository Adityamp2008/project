<?php

namespace App\Exports;

use App\Models\AtkItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AtkItemsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return AtkItem::select('code', 'name', 'category', 'unit', 'stock', 'low_stock_threshold')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Satuan',
            'Stok Saat Ini',
            'Batas Stok Minimum',
        ];
    }
}
