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
        // FORCE : Désactive la vérification des clés étrangères pour éviter l'erreur 1824
        Schema::disableForeignKeyConstraints();

        Schema::create('games', function (Blueprint $table) {
            $table->id();

            // Liaison avec la saison
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');

            // Clés étrangères liées à la table 'equipes'
            $table->foreignId('equipe_a_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('equipe_b_id')->constrained('equipes')->onDelete('cascade');

            // Scores
            $table->integer('score_a')->default(0);
            $table->integer('score_b')->default(0);

            // Métadonnées
            $table->timestamp('joue_le')->useCurrent();
            $table->string('terrain')->nullable();
            $table->date('date_match')->nullable(); // ou dateTime selon le besoin
            $table->string('statut')->default('termine');
            $table->timestamps();
        });

        // RÉACTIVE : Remet la vérification une fois la table créée
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
