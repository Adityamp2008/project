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
        'kategori',
        'kondisi',
        'lokasi',
        'tanggal_perolehan',
        'description',
    ];

    public function riwayats()
    {
        return $this->hasMany(Riwayat::class, 'asset_id');
    }

    protected $dates = ['tanggal_perolehan'];

    /**
     * Relasi ke Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke Lokasi
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    /**
     * Relasi ke Kondisi
     */
    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class, 'kondisi_id');
    }

    /**
     * Relasi ke Riwayat Penggunaan & Perbaikan
     */
    public function riwayat() 
    {
        return $this->hasMany(Riwayat::class, 'asset_id');
    }

    /**
     * Logika otomatis penilaian kelayakan aset
     * - Tidak layak jika umur > 5 tahun atau kondisi buruk
     */
    public function isLayak()
    {
        $maxUmur = 5; // contoh batas usia layak (tahun)
        $kondisiLayak = ['baik', 'normal']; // kondisi yang dianggap layak

        $umurAset = $this->umur ?? $this->calculateUmur();

        return ($umurAset <= $maxUmur)
            && in_array(strtolower($this->kondisi->nama ?? ''), $kondisiLayak);
    }

    /**
     * Hitung umur otomatis berdasarkan tanggal_perolehan
     */
    public function calculateUmur()
    {
        if (!$this->tanggal_perolehan) return 0;
        return Carbon::parse($this->tanggal_perolehan)->diffInYears(now());
    }
}
