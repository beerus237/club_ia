<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeilleureRealisation extends Model
{
    protected $fillable = [
        'titre',
        'categorie',
        'description',
        'image_url',
        'lien',
        'est_actif'
    ];

    protected $casts = [
        'est_actif' => 'boolean'
    ];
}
