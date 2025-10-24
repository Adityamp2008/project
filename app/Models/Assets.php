<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assets extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'nama',
        'kategori_id',
        'lokasi_id',
        'kondisi_id',
        'tanggal_perolehan',
        'umur_tahun',
        'kelayakan',
        'description',
    ];

    protected $dates = ['tanggal_perolehan'];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(lokasi::class, 'lokasi_id');
    }

    public function kondisi()
    {
        return $this->belongsTo(kondisi::class, 'kondisi_id');
    }

    public function riwayats()
    {
        return $this->hasMany(riwayat::class, 'asset_id');
    }   

    protected static function booted()
    {
        static::creating(function ($asset) {
            $asset->hitungUmur();
            $asset->tentukanKelayakan();
        });

        static::updating(function ($asset) {
            $asset->hitungUmur();
            $asset->tentukanKelayakan();
        });
    }

    public function hitungUmur()
    {
        $this->umur_tahun = $this->tanggal_perolehan
            ? Carbon::parse($this->tanggal_perolehan)->diffInYears(now())
            : 0;
    }

    /**
     * Tentukan kelayakan otomatis berdasarkan umur aset
     */
    public function tentukanKelayakan()
    {
        $umur = $this->calculateUmur();

        if ($umur <= 2) {
            $this->kelayakan = 'Layak';
        } elseif ($umur > 2 && $umur <= 4) {
            $this->kelayakan = 'Kurang Layak';
        } else {
            $this->kelayakan = 'Tidak Layak';
        }
    }

    public function calculateUmur()
    {
        if (!$this->tanggal_perolehan) return 0;
        return Carbon::parse($this->tanggal_perolehan)->diffInYears(now());
    }

    public function isLayak()
    {
        return $this->kelayakan === 'Layak';
    }

        public function KelayakanAssets()
    {
        return $this->hasOne(KelayakanAssets::class, 'asset_id');
    }

}
