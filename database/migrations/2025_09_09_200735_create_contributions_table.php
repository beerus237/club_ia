<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();

            // Relation avec l'utilisateur (si connecté)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Type de contribution
            $table->enum('type', ['image', 'texte', 'dataset']);
            $table->string('titre');

            // Champs pour les fichiers
            $table->string('nom_fichier')->nullable();
            $table->text('chemin_fichier')->nullable(); // Pour stocker le chemin ou un JSON pour multiples images

            // Champs pour les textes
            $table->text('contenu_texte')->nullable();

            // Métadonnées spécifiques
            $table->string('nature')->nullable(); // Pour images
            $table->string('thematique')->nullable(); // Pour textes
            $table->string('langue')->nullable(); // Pour textes
            $table->string('domaine')->nullable(); // Pour datasets
            $table->text('description')->nullable();

            // Statut de modération
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            $table->text('raison_rejet')->nullable();

            // Informations de tracking
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Gestion de la modération
            $table->foreignId('traite_par')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('traite_le')->nullable();

            $table->timestamps();

            // Index pour les performances
            $table->index('type');
            $table->index('statut');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
