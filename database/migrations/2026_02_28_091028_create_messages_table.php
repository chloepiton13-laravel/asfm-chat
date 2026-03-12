<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // L'expéditeur du message
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // La conversation à laquelle appartient le message
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');

            // Le contenu du message
            $table->text('body')->nullable();

            // Type de message (text, image, file, audio, video)
            // Utile si vous n'utilisez pas que Laravel Media Library
            $table->string('type')->default('text');

            // État de lecture (optionnel ici, ou via une table pivot pour les groupes)
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Indexation pour accélérer l'affichage de l'historique
            $table->index(['conversation_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
