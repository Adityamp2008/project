<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtkItem extends Model
{
    protected $fillable = ['code','name','description','unit','stock','low_stock_threshold','category','active'];

    public function transactions() { return $this->hasMany(StockTransaction::class); }
    public function usages() { return $this->hasMany(AtkUsage::class); }

    // helper untuk cek stok menipis
    public function isLowStock() {
        return $this->stock <= $this->low_stock_threshold;
    }
}
