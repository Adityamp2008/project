<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKelayakan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kelayakan';

    protected $fillable = [
        'asset_id',
        'petugas_id',
        'status',
        'catatan_petugas',
        'catatan_kepdin',
        'approved_at',
    ];

    // Relasi ke Aset
    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }

    // Relasi ke Petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
