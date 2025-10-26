<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbaikan extends Model
{
    use HasFactory;

    protected $table = "riwayat_perbaikan";

    protected $fillable = [
        'asset_id',
        'deskripsi',
        'biaya',
        'tanggal_perbaikan',
        'diperbaiki_oleh'
    ];

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }
}
