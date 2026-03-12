<?php

namespace Database\Seeders;

use App\Models\Equipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Désactiver les contraintes pour permettre le truncate
        Schema::disableForeignKeyConstraints();

        // 2. Vider la table (et idéalement la table 'games' qui dépend d'elle)
        Equipe::truncate();

        // 3. Réactiver les contraintes
        Schema::enableForeignKeyConstraints();

        // 4. Générer les 15 équipes (WAZALENDO, F23, etc.)
        Equipe::factory(15)->create();

        // 5. Ajout manuel de votre équipe phare
        Equipe::create([
            'nom' => 'ASFM ELITE',
            'sigle' => 'ASFM',
            'est_actif' => true,
            'logo' => 'https://placehold.co'
        ]);
    }
}
