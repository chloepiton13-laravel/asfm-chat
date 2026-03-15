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
        Schema::create('documents_military', function (Blueprint $table) {
            $table->id();

            // Relation avec l'utilisateur (créateur)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identification et Indexation
            $table->string('reference_interne')->unique();
            $table->string('slug')->unique();
            $table->string('objet')->index();

            // Métadonnées Militaires
            $table->string('classification')->default('Diffusion Restreinte'); // Secret, Confidentiel, etc.
            $table->string('priorite_operationnelle')->default('Normal'); // Flash, Immédiat, Prioritaire

            // Emetteur / Destinataire
            $table->string('unite_emetteur');
            $table->string('unite_destinataire');

            // Signature
            $table->string('grade_signataire')->nullable();
            $table->string('nom_signataire')->nullable();
            $table->date('date_signature')->nullable();

            // Contenu et Fichier
            $table->text('corps_message')->nullable();
            $table->string('fichier_joint')->nullable();
            $table->string('statut')->default('Brouillon');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_military');
    }
};
