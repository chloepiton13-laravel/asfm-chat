<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game;
use App\Models\Season;
use App\Models\Standing;
use App\Models\Player;
use App\Models\Equipe;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création de l'Administrateur
        User::factory()->create([
            'name' => 'Admin ASFM',
            'email' => 'admin@asfm.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Création de la Saison Active (Indispensable pour le dashboard)
        $season = Season::create([
            'name' => 'Saison Kinshasa 2024',
            'is_active' => true,
            'start_date' => now()->startOfYear(),
            'end_date' => now()->endOfYear(),
        ]);

        // 3. Injection des Équipes
        $this->call([
            EquipeSeeder::class,
        ]);

        $equipes = Equipe::all();

        // 4. Génération des Joueurs (Top Buteurs)
        foreach ($equipes as $equipe) {
            Player::factory(20)->create([
                'equipe_id' => $equipe->id
            ]);

            // 5. Initialisation du Classement (Standings) pour chaque équipe
            Standing::create([
                'season_id' => $season->id,
                'equipe_id' => $equipe->id,
                'played' => 10,
                'wins' => rand(2, 6),
                'draws' => rand(1, 4),
                'losses' => rand(0, 3),
                'goals_for' => rand(15, 30),
                'goals_against' => rand(10, 20),
                'goal_difference' => rand(5, 10),
                'points' => rand(15, 30),
            ]);
        }

        // 6. Génération des Games (Prochains matchs)
        // On s'assure qu'ils sont liés à la saison créée
        Game::factory(10)->create([
            'season_id' => $season->id,
            'statut' => 'scheduled',
            'joue_le' => now()->addDays(rand(1, 15)),
        ]);

        $this->command->info('Dashboard ASFM prêt avec succès !');
    }
}
