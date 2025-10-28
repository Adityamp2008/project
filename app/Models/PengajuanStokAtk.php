<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanStokAtk extends Model
{
    protected $fillable = [
        'atk_item_id',
        'jenis',
        'jumlah',
        'keterangan',
        'user_id',
        'status',
    ];

    public function item()
    {
        return $this->belongsTo(AtkItem::class, 'atk_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
