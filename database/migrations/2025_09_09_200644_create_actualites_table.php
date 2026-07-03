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
        Schema::create('actualites', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu'); // Contenu complet de l'article
            $table->string('categorie'); // Santé, Agriculture, etc.
            $table->string('image_url')->nullable(); // URL ou chemin vers une image
            $table->string('lien_externe')->nullable(); // Lien vers l'article source
            $table->date('date_publication');
            $table->string('auteur')->nullable();
            $table->boolean('est_publie')->default(false); // Pour gérer le statut
            $table->timestamps(); // Crée created_at et updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};
