<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('categorie'); // Recherche, Éducation, Culturel
            $table->string('equipe')->nullable(); // Nom de l'équipe
            $table->string('statut'); // Terminé, En cours, Planifié
            $table->string('lien_demo')->nullable();
            $table->string('lien_github')->nullable();
            $table->string('image_url')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
