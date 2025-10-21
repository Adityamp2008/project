<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $fillable = [
        'assets_id',
        'tipe',
        'description',
        'tanggal',
    ];

    public function assets()
    {
        return $this->belongsTo(Assets::class, 'assets_id');
    }
}
