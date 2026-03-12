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
         Schema::table('players', function (Blueprint $table) {
             // Ajoute la colonne age (par défaut à 0 ou null)
             $table->integer('age')->nullable()->after('name');
         });
     }

     public function down(): void
     {
         Schema::table('players', function (Blueprint $table) {
             $table->dropColumn('age');
         });
     }

};
