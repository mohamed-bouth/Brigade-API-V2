<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plat;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'user_id',
        'plat_id',
        'score',
        'warning_message',
        'status'
    ];

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function plat(){
        return $this->belongsToMany(Plat::class);
    }
}
