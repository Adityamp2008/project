<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_perbaikan';

    protected $fillable = [
        'tanggal',
        'deskripsi',
        'biaya',
        'teknisi',
        'asset_type',
        'asset_id',
        'atk_id',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }

    public function atk()
    {
        return $this->belongsTo(AtkItem::class, 'atk_id');
    }

    public function riwayatPerbaikan()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'asset_id');
    }

}
