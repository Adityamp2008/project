<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtkUsage extends Model
{
    protected $fillable = ['atk_item_id','user_id','quantity','note'];
    public function item() { return $this->belongsTo(AtkItem::class,'atk_item_id'); }
}
