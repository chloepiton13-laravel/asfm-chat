<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            // =========================
            // LIAISON LIGUE (Indispensable)
            // =========================
            $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');
            $table->integer('goals')->default(0); // Nécessaire pour le Top Buteurs

            // =========================
            // IDENTIFICATION
            // =========================
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nationality')->default('Congolaise');
            $table->string('profession')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // =========================
            // INFORMATIONS SPORTIVES
            // =========================
            $table->string('selection_name')->nullable();
            $table->string('position')->nullable();
            $table->string('foot')->nullable();
            $table->integer('jersey_number')->nullable();
            $table->year('join_year')->nullable();
            $table->string('previous_club')->nullable();
            $table->string('level')->nullable();
            $table->boolean('is_fit')->default(false);

            // =========================
            // DOCUMENTS
            // =========================
            $table->string('identity_document')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->json('other_documents')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
