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
         Schema::create('equipes', function (Blueprint $table) {
             $table->id();
             $table->string('nom')->unique();
             $table->string('sigle', 10)->nullable();
             $table->string('logo')->nullable();
             $table->boolean('is_guest')->default(false); // <--- AJOUTÉ
             $table->boolean('est_actif')->default(true);
             $table->timestamps();
         });
     }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipes');
    }
};
