<?php

namespace App\Models;

use App\Models\Plat;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'tags'
    ];

    public function plats()
    {
        return $this->belongsToMany(Plat::class)->withTimestamps();
    }
}
