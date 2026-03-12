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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            // Lien avec l'équipe (la sélection)
            $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');

            // Détails du paiement
            $table->decimal('montant', 10, 2)->default(10000.00); // 10.000 FC par défaut
            $table->date('mois_concerne'); // Date pour identifier le mois (ex: 2024-03-01)

            // Suivi
            $table->enum('statut', ['paye', 'en_attente', 'annule'])->default('paye');
            $table->string('reference_paiement')->nullable(); // Ex: N° de reçu ou transaction
            $table->text('notes')->nullable(); // Pour des précisions éventuelles

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
