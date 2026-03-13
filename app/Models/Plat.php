<?php

namespace App\Models;
use App\Models\Category;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id',
        'category_id',
        'image'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsTo(Category::class);
    }
}

