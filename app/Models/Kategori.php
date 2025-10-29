<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama', 'tipe'];
    
    public function atkItems()
    {
        return $this->hasMany(AtkItem::class, 'kategori_id');
    }
}

// App\Models\Kategori.php


