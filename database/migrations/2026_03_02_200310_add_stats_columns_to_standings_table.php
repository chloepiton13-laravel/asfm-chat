<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
      Schema::table('standings', function (Blueprint $table) {
          if (!Schema::hasColumn('standings', 'won')) $table->integer('won')->default(0)->after('played');
          if (!Schema::hasColumn('standings', 'drawn')) $table->integer('drawn')->default(0)->after('won');
          if (!Schema::hasColumn('standings', 'lost')) $table->integer('lost')->default(0)->after('drawn');

          if (!Schema::hasColumn('standings', 'goals_for')) $table->integer('goals_for')->default(0)->after('lost');
          if (!Schema::hasColumn('standings', 'goals_against')) $table->integer('goals_against')->default(0)->after('goals_for');
          if (!Schema::hasColumn('standings', 'goal_difference')) $table->integer('goal_difference')->default(0)->after('goals_against');

          if (!Schema::hasColumn('standings', 'evolution')) $table->integer('evolution')->default(0)->after('points');
          if (!Schema::hasColumn('standings', 'last_five')) $table->string('last_five')->nullable()->after('evolution');
      });
  }

    public function down(): void
    {
        Schema::table('standings', function (Blueprint $blueprint) {
            $blueprint->dropColumn([
                'won', 'drawn', 'lost',
                'goals_for', 'goals_against', 'goal_difference',
                'evolution', 'last_five'
            ]);
        });
    }
};
