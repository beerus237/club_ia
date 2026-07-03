<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'description', 'categorie', 'equipe', 'statut', 'lien_demo', 'lien_github', 'image_url', 'date_debut', 'date_fin'
    ];
    protected $dates = ['date_debut', 'date_fin'];
}
