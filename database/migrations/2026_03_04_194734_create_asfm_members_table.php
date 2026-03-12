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
       Schema::create('asfm_members', function (Blueprint $table) {
           $table->id();

           // Identité
           $table->string('nom');
           $table->string('prenom');
           $table->string('postnom')->nullable();

           // --- PHOTO & FONCTION ---
           $table->string('photo')->nullable();
           $table->string('fonction')->default('Membre'); // La colonne manquante est ici
           $table->boolean('est_actif')->default(true);

           // Contact
           $table->string('email')->unique()->nullable();
           $table->string('telephone')->nullable();

           // Relation
           $table->foreignId('equipe_id')->nullable()->constrained('equipes')->onDelete('set null');

           $table->timestamps();
       });
     }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asfm_members');
    }
};
