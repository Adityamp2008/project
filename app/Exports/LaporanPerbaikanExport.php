<?php

namespace App\Exports;

use App\Models\RiwayatPerbaikan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class LaporanPerbaikanExport implements FromCollection, WithHeadings
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = RiwayatPerbaikan::query();

        if ($this->request->filled('dari') && $this->request->filled('sampai')) {
            $query->whereBetween('tanggal', [$this->request->dari, $this->request->sampai]);
        }

        if ($this->request->filled('asset_type')) {
            $query->where('asset_type', $this->request->asset_type);
        }

        if ($this->request->filled('teknisi')) {
            $query->where('teknisi', 'like', "%{$this->request->teknisi}%");
        }

        return $query->get(['tanggal', 'deskripsi', 'biaya', 'teknisi', 'asset_type']);
    }

    public function headings(): array
    {
        return ['Tanggal', 'Deskripsi', 'Biaya', 'Teknisi', 'Tempat Data'];
    }
}
