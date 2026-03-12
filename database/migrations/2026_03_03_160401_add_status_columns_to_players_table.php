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
             $table->boolean('is_active')->default(true)->after('age');
             $table->boolean('has_licence')->default(false)->after('is_active');
             $table->boolean('is_medical_ok')->default(false)->after('has_licence');
         });
     }

     public function down(): void
     {
         Schema::table('players', function (Blueprint $table) {
             $table->dropColumn(['is_active', 'has_licence', 'is_medical_ok']);
         });
     }

};
