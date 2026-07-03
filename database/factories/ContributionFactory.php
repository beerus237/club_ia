<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContributionFactory extends Factory
{
    public function definition(): array
    {
        // Choisir un type aléatoirement
        $type = fake()->randomElement(['image', 'texte', 'dataset']);

        // Définir des données spécifiques en fonction du type
        $donneesSpecifiques = $this->getDonneesParType($type);

        return array_merge([
            'user_id' => fake()->optional(0.7)->randomDigitNotNull, // 70% de chance d'avoir un user_id
            'type' => $type,
            'titre' => fake()->sentence(3),
            'statut' => fake()->randomElement(['en_attente', 'approuve', 'rejete']),
            'raison_rejet' => fn (array $attributes) =>
                ($attributes['statut'] === 'rejete') ? fake()->sentence() : null,
        ], $donneesSpecifiques);
    }

    private function getDonneesParType(string $type): array
    {
        return match($type) {
            'image' => [
                'nom_fichier' => 'image_'.fake()->word.'.jpg',
                'chemin_fichier' => 'contributions/images/'.fake()->filePath(),
                'contenu_texte' => null,
                'nature' => fake()->randomElement(['portrait', 'medical', 'agriculture', 'elevage', 'culture', 'urbain', 'nature']),
                'thematique' => null,
                'langue' => null,
                'domaine' => null,
                'description' => fake()->sentence(),
            ],
            'texte' => [
                'nom_fichier' => null,
                'chemin_fichier' => null,
                'contenu_texte' => fake()->paragraphs(3, true),
                'nature' => null,
                'thematique' => fake()->randomElement(['contes', 'traditions', 'histoire', 'savoir', 'quotidien']),
                'langue' => fake()->randomElement(['français', 'anglais', 'ewondo', 'dual', 'bassa']),
                'domaine' => null,
                'description' => null,
            ],
            'dataset' => [
                'nom_fichier' => 'dataset_'.fake()->word.'.csv',
                'chemin_fichier' => 'contributions/datasets/'.fake()->filePath(),
                'contenu_texte' => null,
                'nature' => null,
                'thematique' => null,
                'langue' => null,
                'domaine' => fake()->randomElement(['sante', 'agriculture', 'elevage', 'environnement', 'education', 'economie']),
                'description' => fake()->paragraph(),
            ],
        };
    }
}
