<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crée d'abord quelques utilisateurs
        \App\Models\User::factory(10)->create(); // 10 utilisateurs normaux
        \App\Models\User::factory()->create([ // 1 admin spécifique
            'name' => 'Admin',
            'email' => 'admin@clubia-enspd.cm',
            'password' => bcrypt('password123'), // Changez ceci en production !
            'role' => 'admin',
        ]);

        // Crée les autres données
        \App\Models\Actualite::factory(15)->create();
        \App\Models\Evenement::factory(8)->create();
        \App\Models\Projet::factory(12)->create();
        \App\Models\Contribution::factory(25)->create();
    }
}
