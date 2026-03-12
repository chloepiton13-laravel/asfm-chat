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
         Schema::create('games', function (Blueprint $table) {
             $table->id();

             // AJOUT : Liaison avec la saison (doit être placée avant les équipes)
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
             $table->string('statut')->default('termine');
             $table->timestamps();
         });
     }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
