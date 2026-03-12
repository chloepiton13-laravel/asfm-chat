<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // --- Identifiants de base ---
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- Système de Chat ASFM ---
            // Pseudo unique pour les recherches et mentions
            $table->string('username')->unique()->nullable();

            // Photo de profil (URL ou chemin vers storage)
            $table->string('avatar')->nullable();

            // Bio / Statut (ex: "Occupé", "En réunion")
            $table->string('about')->nullable();

            // Statut de connexion (Point vert)
            $table->boolean('is_online')->default(false)->index();

            // Dernière activité pour le "Vu il y a..."
            $table->timestamp('last_seen_at')->nullable();

            // --- Sécurité & Fortify (2FA) ---
            // Stocke la clé secrète cryptée
            $table->text('two_factor_secret')->nullable();

            // Stocke les codes de secours cryptés (JSON)
            $table->text('two_factor_recovery_codes')->nullable();

            // Date de confirmation réelle du 2FA
            $table->timestamp('two_factor_confirmed_at')->nullable();

            // --- Maintenance & Sessions ---
            // Pour ne pas supprimer les messages si l'user part
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        // Table pour la réinitialisation des mots de passe
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Table pour la gestion des sessions (Requis par Fortify)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
