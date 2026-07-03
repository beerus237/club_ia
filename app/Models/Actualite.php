<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;
    // Spécifie les champs qui peuvent être remplis massivement (via create() ou update())
    protected $fillable = [
        'titre', 'contenu', 'categorie', 'image_url', 'lien_externe', 'date_publication', 'auteur', 'est_publie'
    ];
    // Spécifie les champs qui doivent être traités comme des dates Carbon
    protected $dates = ['date_publication'];
}
