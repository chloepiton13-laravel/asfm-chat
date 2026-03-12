<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();

            // Celui qui envoie la demande (Expéditeur)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Celui qui reçoit la demande (Destinataire)
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade');

            // État de la relation : en attente, amis, ou bloqué
            $table->enum('status', ['pending', 'accepted', 'blocked'])->default('pending');

            // Date de début de l'amitié
            $table->timestamp('accepted_at')->nullable();

            $table->timestamps();

            // Empêche les doublons (ex: deux demandes identiques)
            $table->unique(['user_id', 'friend_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
