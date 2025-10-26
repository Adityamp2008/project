<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenghapusanAtk extends Model
{
    use HasFactory;

    protected $table = 'penghapusan_atk';
    protected $fillable = ['atk_item_id', 'user_id', 'alasan', 'status'];

    public function item()
    {
        return $this->belongsTo(AtkItem::class, 'atk_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
