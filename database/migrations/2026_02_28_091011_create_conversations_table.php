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
         Schema::create('conversations', function (Blueprint $table) {
             $table->id();

             // Nom du groupe (null si c'est un chat privé entre 2 personnes)
             $table->string('name')->nullable();

             // Indique si c'est un groupe ou une discussion privée
             $table->boolean('is_group')->default(false);

             // Photo du groupe (si applicable)
             $table->string('group_photo')->nullable();

             // Optimisation : On stocke les infos du dernier message envoyé
             // pour éviter des requêtes lourdes sur la liste des discussions
             $table->text('last_message_content')->nullable();
             $table->timestamp('last_message_at')->nullable();

             $table->timestamps();

             // Supprime proprement si l'app évolue
             $table->softDeletes();
         });
     }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
