<?php

namespace App\Models;
use App\Models\Category;
use App\Models\User;
use App\Models\Recommendation;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id',
        'category_id',
        'image',
        'is_available'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }

    public function recommendations(){
        return $this->hasMany(Recommendation::class);
    }
}

