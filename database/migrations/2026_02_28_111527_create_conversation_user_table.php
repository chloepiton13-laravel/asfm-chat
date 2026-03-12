<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversation_user', function (Blueprint $table) {
            $table->id();

            // Lien vers l'utilisateur
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Lien vers la conversation
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');

            // Rôle dans la conversation (Utile pour les groupes : admin, membre)
            $table->string('role')->default('member');

            // Date d'arrivée dans la discussion
            $table->timestamps();

            // Indexation pour accélérer les recherches de conversations par utilisateur
            $table->unique(['user_id', 'conversation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversation_user');
    }
};
