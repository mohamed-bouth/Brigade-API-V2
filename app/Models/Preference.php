<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Preference extends Model
{
    protected $fillable = [
        'ingredient',
        'type',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
