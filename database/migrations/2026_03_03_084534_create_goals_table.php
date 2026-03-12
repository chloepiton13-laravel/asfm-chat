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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            // Le match durant lequel le but a été marqué
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');

            // Le buteur (référence ta table players existante)
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');

            // L'équipe qui a marqué (utile pour filtrer rapidement par équipe)
            $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');

            // Optionnel : la minute du but
            $table->integer('minute')->nullable();
            $table->tinyInteger('periode')->default(1);
            $table->integer('additionnel')->default(0);
            // Optionnel : type de but (tête, penalty, contre son camp...)
            $table->string('type')->default('normal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
