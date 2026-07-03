<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActualiteFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Santé', 'Agriculture', 'Éducation', 'Environnement', 'Technologie', 'Innovation'];
        return [
            'titre' => fake()->sentence(6),
            'contenu' => fake()->paragraphs(3, true),
            'categorie' => fake()->randomElement($categories),
            'image_url' => 'https://picsum.photos/seed/'.fake()->word.'/800/400',
            'lien_externe' => 'https://example.com/article-'.Str::random(10),
            'date_publication' => fake()->dateTimeBetween('-3 months', 'now'),
            'auteur' => fake()->name(),
            'est_publie' => true,
        ];
    }
}
