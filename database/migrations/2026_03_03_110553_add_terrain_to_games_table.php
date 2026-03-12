<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Ajout du champ terrain (nullable au cas où certains vieux matchs n'en ont pas)
            $table->string('terrain')->nullable()->after('joue_le');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('terrain');
        });
    }
};
