<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'image_url',
        'ordre',
        'est_actif'
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'ordre' => 'integer'
    ];
}
