<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
