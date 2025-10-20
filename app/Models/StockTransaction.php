<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = ['atk_item_id','type','quantity','reference','user_id'];

    public function item() { return $this->belongsTo(AtkItem::class,'atk_item_id'); }
}
