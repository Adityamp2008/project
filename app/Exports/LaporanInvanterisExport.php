<?php

namespace App\Exports;

use App\Models\Assets;
use App\Models\AtkItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanInventarisExport implements FromCollection, WithHeadings
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $controller = new \App\Http\Controllers\Admin\RiwayatPerbaikanController();
        return $controller->ambilDataInventaris($this->request);
    }

    public function headings(): array
    {
        return ['Jenis','Nama','Kategori','Kondisi','Lokasi','Stok'];
    }
}
