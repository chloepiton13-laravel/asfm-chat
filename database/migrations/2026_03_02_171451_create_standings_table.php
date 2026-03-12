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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            // Relations
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipe_id')->constrained()->onDelete('cascade');

            // Statistiques de match
            $table->integer('played')->default(0);      // MJ (Matchs Joués)
            $table->integer('wins')->default(0);        // G (Gagnés)
            $table->integer('draws')->default(0);       // N (Nuls)
            $table->integer('losses')->default(0);      // P (Perdus)

            // Statistiques de buts
            $table->integer('goals_for')->default(0);     // BP (Buts Pour)
            $table->integer('goals_against')->default(0); // BC (Buts Contre)
            $table->integer('goal_difference')->default(0); // DB (Différence de Buts)

            // Points
            $table->integer('points')->default(0);      // Pts

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
