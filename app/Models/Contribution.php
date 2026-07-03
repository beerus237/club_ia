<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'titre', 'nom_fichier', 'chemin_fichier',
        'contenu_texte', 'nature', 'thematique', 'langue', 'domaine',
        'description', 'statut', 'raison_rejet', 'ip_address', 'user_agent',
        'traite_par', 'traite_le'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'traite_le' => 'datetime',
        'chemin_fichier' => 'array', // Cast pour les images multiples
    ];

    protected $appends = ['fichiers_urls', 'taille_fichier_formatee'];

    /**
     * Relation avec l'utilisateur contributeur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'admin qui a traité la contribution
     */
    public function traitePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    /**
     * Accessor pour les URLs des fichiers (robuste face aux anciennes données
     * de contributions "image" qui avaient été doublement encodées en JSON).
     */
    public function getFichiersUrlsAttribute()
    {
        $paths = $this->chemin_fichier;

        if (!$paths) {
            return [];
        }

        // Ancien format : chaîne JSON encodée deux fois pour les images multiples.
        if (is_string($paths)) {
            $decoded = json_decode($paths, true);
            $paths = is_array($decoded) ? $decoded : [$paths];
        }

        if (!is_array($paths)) {
            return [];
        }

        return array_values(array_filter(array_map(function ($path) {
            if (!is_string($path) || !Storage::disk('public')->exists($path)) {
                return null;
            }

            return [
                'url' => Storage::disk('public')->url($path),
                'name' => basename($path),
                'extension' => strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            ];
        }, $paths)));
    }

    /**
     * Taille lisible du fichier principal (utile pour les datasets).
     */
    public function getTailleFichierFormateeAttribute(): ?string
    {
        $path = $this->chemin_fichier;

        if (is_array($path)) {
            $path = $path[0] ?? null;
        }

        if (!is_string($path) || !Storage::disk('public')->exists($path)) {
            return null;
        }

        $bytes = Storage::disk('public')->size($path);

        if ($bytes < 1024) {
            return $bytes . ' o';
        }
        if ($bytes < 1024 * 1024) {
            return round($bytes / 1024, 1) . ' Ko';
        }

        return round($bytes / (1024 * 1024), 1) . ' Mo';
    }

    /**
     * Vérifie si la contribution a des fichiers
     */
    public function hasFiles(): bool
    {
        return !empty($this->chemin_fichier);
    }

    /**
     * Scope pour les contributions approuvées
     */
    public function scopeApprouvees($query)
    {
        return $query->where('statut', 'approuve');
    }

    /**
     * Scope pour les contributions en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les contributions rejetées
     */
    public function scopeRejetees($query)
    {
        return $query->where('statut', 'rejete');
    }

    /**
     * Scope pour les contributions par type
     */
    public function scopeParType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Accessor pour le statut formaté
     */
    public function getStatutFormateAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'approuve' => 'Approuvé',
            'rejete' => 'Rejeté',
            default => $this->statut
        };
    }

    /**
     * Accessor pour le type formaté
     */
    public function getTypeFormateAttribute(): string
    {
        return match($this->type) {
            'image' => 'Image',
            'texte' => 'Texte',
            'dataset' => 'Dataset',
            default => $this->type
        };
    }
}
