<?php

namespace App\Exports;

use App\Models\RiwayatPerbaikan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanPerbaikanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return RiwayatPerbaikan::with('asset')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Aset',
            'Deskripsi Perbaikan',
            'Biaya',
            'Diperbaiki Oleh',
            'Tanggal Perbaikan',
        ];
    }

    public function map($riwayat): array
    {
        static $no = 1;
        return [
            $no++,
            $riwayat->asset->nama ?? '-',
            $riwayat->deskripsi_perbaikan,
            'Rp ' . number_format($riwayat->biaya, 0, ',', '.'),
            $riwayat->diperbaiki_oleh,
            $riwayat->tanggal_perbaikan ? $riwayat->tanggal_perbaikan->format('d-m-Y') : '-',
        ];
    }
}
