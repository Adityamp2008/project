<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assets extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'lokasi',
        'tanggal_perolehan',
        'kondisi',
        'umur_tahun',
        'description',
    ];

    // Relasi ke kelayakan
    public function KelayakanAssets()
    {
        return $this->hasOne(KelayakanAssets::class, 'asset_id');
    }

    // Hitung umur aset (dalam tahun)
    public function calculateUmur()
    {
        if (!$this->tanggal_perolehan) return 0;
        return Carbon::parse($this->tanggal_perolehan)->diffInYears(Carbon::now());
    }

    // Getter status kelayakan otomatis
    public function getStatusKelayakanAttribute()
    {
        if (!$this->KelayakanAssets) return '-';
        return $this->KelayakanAssets->status_kelayakan;
    }

    public function getKeteranganKelayakanAttribute()
    {
        return $this->KelayakanAssets->keterangan ?? '-';
    }
}
