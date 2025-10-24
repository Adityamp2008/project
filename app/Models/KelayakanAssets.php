<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanAssets extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_assets';

    protected $fillable = [
        'asset_id',
        'status_kelayakan',
        'keterangan',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }
}
