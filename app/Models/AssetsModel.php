<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetsModel extends Model
{
    // Aset.php
    public function getStatusKelayakanAttribute()
    {
        $umur = \Carbon\Carbon::parse($this->tanggal_perolehan)->age;
        $jumlahPerbaikan = $this->riwayat()->where('tipe', 'perbaikan')->count();
        $kondisi = $this->kondisi->nama_kondisi;

        if ($umur <= 5 && $jumlahPerbaikan < 3 && strtolower($kondisi) === 'baik') {
            return 'Layak';
        }

        return 'Tidak Layak';
    }

}
