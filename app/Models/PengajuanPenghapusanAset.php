<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenghapusanAset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'diajukan_oleh',
        'alasan',
        'status',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }
}
