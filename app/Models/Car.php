<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guard = [];


    public function user()
    {
        return $this->belongsTo(related: User::class);
    }
}
