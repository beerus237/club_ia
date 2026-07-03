<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjetFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Recherche', 'Éducation', 'Culturel', 'Innovation'];
        $statuts = ['Terminé', 'En cours', 'Planifié'];
        $equipes = ['Équipe MedIA', 'Équipe AgroTech', 'Équipe Lingua', 'Équipe Vision', 'Équipe Robotics'];

        $dateDebut = fake()->dateTimeBetween('-1 year', 'now');
        // Si le statut est "Terminé", génère une date de fin après la date de début
        $statut = fake()->randomElement($statuts);
        $dateFin = ($statut === 'Terminé')
            ? Carbon::parse($dateDebut)->addMonths(fake()->numberBetween(3, 12))
            : null;

        return [
            'titre' => fake()->sentence(5),
            'description' => fake()->paragraphs(4, true),
            'categorie' => fake()->randomElement($categories),
            'equipe' => fake()->randomElement($equipes),
            'statut' => $statut,
            'lien_demo' => fake()->optional(0.7)->url(), // 70% de chance d'avoir un lien
            'lien_github' => fake()->optional(0.8)->url(), // 80% de chance d'avoir un lien
            'image_url' => 'https://picsum.photos/seed/project-'.fake()->word.'/800/400',
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ];
    }
}
