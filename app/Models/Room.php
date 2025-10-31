<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
    
    public function assets()
    {
        return $this->hasMany(Assets::class);
    }
    
    public function atkItems()
    {
        return $this->hasMany(AtkItem::class);
    }

}
