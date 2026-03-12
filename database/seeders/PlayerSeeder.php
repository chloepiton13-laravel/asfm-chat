<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Equipe;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On récupère toutes les équipes créées par l'EquipeSeeder
        $equipes = Equipe::all();

        if ($equipes->isEmpty()) {
            $this->command->warn("Aucune équipe trouvée. Lancez d'abord EquipeSeeder !");
            return;
        }

        foreach ($equipes as $equipe) {
            // On génère entre 18 et 22 joueurs par équipe de Kinshasa
            Player::factory()
                ->count(rand(18, 22))
                ->create([
                    'equipe_id' => $equipe->id,
                ]);
        }

        $this->command->info("Les effectifs des équipes ASFM ont été générés avec succès.");
    }
}
