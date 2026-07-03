<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EvenementFactory extends Factory
{
    public function definition(): array
    {
        // Génère une date de début aléatoire dans les 6 prochains mois
        $dateDebut = fake()->dateTimeBetween('now', '+6 months');
        // Génère une date de fin 2 à 6 heures après le début
        $dateFin = Carbon::parse($dateDebut)->addHours(fake()->numberBetween(2, 6));

        $lieux = ['Amphithéâtre ENSPD', 'Salle 32BP2', 'Campus ENSPD', 'Hôtel de Ville de Douala', 'Espace Coworking TekJi'];

        return [
            'titre' => fake()->sentence(4),
            'description' => fake()->paragraphs(2, true),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'lieu' => fake()->randomElement($lieux),
            'nombre_places' => fake()->randomElement([50, 100, 150, 200, 300]),
            'participants_inscrits' => fn (array $attributes) =>
                fake()->numberBetween(0, $attributes['nombre_places']),
            'image_url' => 'https://picsum.photos/seed/event-'.fake()->word.'/800/400',
            'est_actif' => true,
        ];
    }
}
