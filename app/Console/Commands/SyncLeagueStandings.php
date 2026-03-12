<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipe;
use App\Models\Game;
use App\Models\Standing;
use App\Models\Season;

class SyncLeagueStandings extends Command
{
    protected $signature = 'app:sync-league-standings';
    protected $description = 'Recalcule le classement complet de la saison active';

    public function handle()
    {
        $this->info('Début du calcul du classement...');

        $season = Season::where('is_active', true)->first();
        if (!$season) {
            $this->error('Aucune saison active trouvée.');
            return;
        }

        $equipes = Equipe::all();

        foreach ($equipes as $equipe) {
            // Récupérer les matchs terminés de cette équipe pour la saison
            $games = Game::where('season_id', $season->id)
                ->where(function($query) use ($equipe) {
                    $query->where('equipe_a_id', $equipe->id) // CORRIGÉ
                          ->orWhere('equipe_b_id', $equipe->id); // CORRIGÉ
                })
                ->where('statut', 'termine')
                ->orderBy('joue_le', 'asc')
                ->get();

            $stats = [
                'played' => 0, 'won' => 0, 'drawn' => 0, 'lost' => 0,
                'bp' => 0, 'bc' => 0, 'pts' => 0, 'form' => []
            ];

            foreach ($games as $game) {
                // CORRIGÉ : Vérification avec equipe_a_id
                $isHome = $game->equipe_a_id == $equipe->id;
                $scoreFor = $isHome ? $game->score_a : $game->score_b;
                $scoreAgainst = $isHome ? $game->score_b : $game->score_a;

                $stats['played']++;
                $stats['bp'] += $scoreFor;
                $stats['bc'] += $scoreAgainst;

                if ($scoreFor > $scoreAgainst) {
                    $stats['won']++;
                    $stats['pts'] += 3;
                    $stats['form'][] = 'W';
                } elseif ($scoreFor == $scoreAgainst) {
                    $stats['drawn']++;
                    $stats['pts'] += 1;
                    $stats['form'][] = 'D';
                } else {
                    $stats['lost']++;
                    $stats['form'][] = 'L';
                }
            }

            // Générer la chaîne des 5 derniers résultats
            $lastFive = implode(',', array_slice(array_reverse($stats['form']), 0, 5));

            Standing::updateOrCreate(
                [
                    'season_id' => $season->id,
                    'equipe_id' => $equipe->id
                ],
                [
                    'played' => $stats['played'],
                    'won' => $stats['won'],
                    'drawn' => $stats['drawn'],
                    'lost' => $stats['lost'],
                    'goals_for' => $stats['bp'],
                    'goals_against' => $stats['bc'],
                    'goal_difference' => $stats['bp'] - $stats['bc'],
                    'points' => $stats['pts'],
                    'last_five' => $lastFive,
                ]
            );
        }

        $this->info('Classement mis à jour avec succès !');
    }
}
