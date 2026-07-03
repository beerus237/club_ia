<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'description', 'date_debut', 'date_fin', 'lieu', 'nombre_places', 'participants_inscrits', 'image_url', 'est_actif'
    ];
    protected $dates = ['date_debut', 'date_fin'];
}
