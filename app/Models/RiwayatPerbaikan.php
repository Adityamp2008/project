<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbaikan extends Model
{
    // Nama tabel (kalau tidak sesuai konvensi Laravel)
    protected $table = 'riwayat_perbaikan';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'asset_id',
        'deskripsi',
        'biaya',
        'diperbaiki_oleh',
        'tanggal_perbaikan',
        'tanggal_selesai',
        'status',
    ];

    /**
     * Relasi ke model Assets
     */
    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }

    /**
     * Accessor opsional untuk format tanggal
     */
    public function getTanggalPerbaikanFormatAttribute()
    {
        return $this->tanggal_perbaikan
            ? \Carbon\Carbon::parse($this->tanggal_perbaikan)->format('d-m-Y')
            : '-';
    }

    public function getTanggalSelesaiFormatAttribute()
    {
        return $this->tanggal_selesai
            ? \Carbon\Carbon::parse($this->tanggal_selesai)->format('d-m-Y')
            : '-';
    }
}
