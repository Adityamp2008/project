<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assets extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kategori_id','room_id', 'lokasi', 'tanggal_perolehan', 'kondisi',
        'umur_tahun', 'description', 'pernah_diperbaiki'
    ];

    public function KelayakanAssets()
    {
        return $this->hasOne(KelayakanAssets::class, 'asset_id');
    }

    public function kelayakanAsset()
    {
        return $this->hasOne(KelayakanAssets::class, 'asset_id');
    }

    public function laporanKelayakan()
    {
        return $this->hasMany(\App\Models\LaporanKelayakan::class, 'asset_id');
    }

    public function laporanKelayakanTerakhir()
    {
        return $this->hasOne(\App\Models\LaporanKelayakan::class, 'asset_id')->latest();
    }

    public function izinPerbaikanTerakhir()
    {
        return $this->hasOne(\App\Models\LaporanKelayakan::class, 'asset_id')->latest();
    }

    public function riwayatPerbaikan()
    {
        return $this->hasMany(\App\Models\RiwayatPerbaikan::class, 'asset_id');
    }

    public function calculateUmur()
    {
        if (!$this->tanggal_perolehan) return 0;
        return Carbon::parse($this->tanggal_perolehan)->diffInYears(Carbon::now());
    }

    public function getStatusKelayakanAttribute()
    {
        return $this->KelayakanAssets->status_kelayakan ?? '-';
    }

    public function getKeteranganKelayakanAttribute()
    {
        return $this->KelayakanAssets->keterangan ?? '-';
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
