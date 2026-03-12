<?php

// database/migrations/xxxx_xx_xx_add_stats_columns_to_equipes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipes', function (Blueprint $table) {
            // On ajoute les colonnes avec une valeur par défaut à 0
            $table->integer('points')->default(0)->after('is_guest');
            $table->integer('matchs_joues')->default(0)->after('points');
            $table->integer('buts_pour')->default(0)->after('matchs_joues');
            $table->integer('buts_contre')->default(0)->after('buts_pour');
            $table->integer('difference_buts')->default(0)->after('buts_contre');
        });
    }

    public function down(): void
    {
        Schema::table('equipes', function (Blueprint $table) {
            $table->dropColumn(['points', 'matchs_joues', 'buts_pour', 'buts_contre', 'difference_buts']);
        });
    }
};
