<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'nama',
        'kategoris_id',
        'lokasi_id',
        'kondisi_id',
        'tanggal_perolehan',
        'umur',
        'deskripsi',
    ];

    protected $dates = ['tanggal_perolehan'];

    /**
     * Relasi ke Kategori
     */
    public function kategoris()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke Lokasi
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    /**
     * Relasi ke Kondisi
     */
    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class);
    }

    /**
     * Relasi ke Riwayat Penggunaan & Perbaikan
     */
    public function riwayats()
    {
        return $this->hasMany(Riwayat::class);
    }

    /**
     * Logika otomatis penilaian kelayakan assets
     * Contoh sederhana:
     *  - Jika umur lebih dari 5 tahun atau kondisi buruk, maka tidak layak
     */
    public function isLayak()
    {
        $maxUmur = 5; // contoh batas usia layak (tahun)

        $kondisiLayak = ['baik', 'normal']; // contoh kondisi layak

        $umurassets = $this->umur ?? $this->calculateUmur();

        return ($umurassets <= $maxUmur) && in_array(strtolower($this->kondisi->nama ?? ''), $kondisiLayak);
    }

    /**
     * Contoh fungsi hitung umur otomatis berdasarkan tanggal_perolehan
     */
    public function calculateUmur()
    {
        if (!$this->tanggal_perolehan) return 0;

        return now()->diffInYears($this->tanggal_perolehan);
    }
}
