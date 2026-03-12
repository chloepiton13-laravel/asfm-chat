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
      Schema::create('asfm_equipements', function (Blueprint $table) {
          $table->id();
          $table->string('nom'); // Ex: Ballons Nike Strike
          $table->string('categorie'); // Entraînement, Match, Médical
          $table->integer('quantite_totale')->default(0);
          $table->integer('quantite_disponible')->default(0);
          $table->string('etat')->default('neuf'); // Neuf, Usé, À remplacer
          $table->timestamps();
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asfm_equipements');
    }
};
