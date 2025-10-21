<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kondisi extends Model
{
    use HasFactory;

    protected $table = 'kondisis';

    public function assets()
    {
        return $this->hasMany(Assets::class, 'kondisi_id');
    }
}
