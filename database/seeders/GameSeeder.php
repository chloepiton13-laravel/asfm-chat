<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Equipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Désactiver les contraintes pour vider proprement la table
        Schema::disableForeignKeyConstraints();
        Game::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Vérifier si des équipes existent, sinon en créer via le EquipeSeeder
        if (Equipe::count() === 0) {
            $this->call(EquipeSeeder::class);
        }

        // 3. Générer 20 matchs de test via la Factory
        Game::factory(20)->create();
    }
}
