<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use App\Models\Player;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts::dashboard')]
#[Title('Full League Standings')]
class AsfmFullLeagueStandings extends Component
{
    use WithPagination;

    // Dans App/Livewire/Pages/AsfmFullLeagueStandings.php

    public function downloadPdf()
    {
        // 1. Récupération du classement complet via la méthode privée
        $standings = $this->calculateStandings();

        // 2. Récupération de TOUS les buteurs sans pagination
        $topScorers = \App\Models\Player::with('equipe')
            ->withCount('goals')
            ->orderByDesc('goals_count')
            ->get();

        // 3. Chargement de la vue PDF avec les données
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.full-report', [
            'standings' => $standings,
            'topScorers' => $topScorers
        ])->setPaper('a4', 'portrait');

        // 4. Téléchargement avec nom de fichier daté
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'rapport-asfm-' . now()->format('d-m-Y') . '.pdf');
    }

    /**
     * Logique de calcul partagée entre le render() et le PDF
     */
    private function calculateStandings()
    {
        $equipes = \App\Models\Equipe::where('est_actif', true)
            ->with(['gamesDomicile' => fn($q) => $q->where('statut', 'termine'),
                    'gamesExterieur' => fn($q) => $q->where('statut', 'termine')])
            ->get();

        return $equipes->map(function ($equipe) {
            $stats = [
                'id'    => $equipe->id,
                'nom'   => $equipe->nom,
                'sigle' => $equipe->sigle,
                'logo'  => $equipe->logo,
                'mj' => 0, 'g' => 0, 'n' => 0, 'p' => 0,
                'bp' => 0, 'bc' => 0, 'pts' => 0,
                'forme' => []
            ];

            $matchs = $equipe->gamesDomicile->concat($equipe->gamesExterieur)->sortByDesc('joue_le');

            foreach ($matchs as $game) {
                $isA = $game->equipe_a_id === $equipe->id;
                $scoreEcheance = $isA ? $game->score_a : $game->score_b;
                $scoreAdversaire = $isA ? $game->score_b : $game->score_a;
                $stats['mj']++;
                $stats['bp'] += $scoreEcheance;
                $stats['bc'] += $scoreAdversaire;

                if ($scoreEcheance > $scoreAdversaire) {
                    $stats['g']++; $stats['pts'] += 3;
                    if (count($stats['forme']) < 5) $stats['forme'][] = 'G';
                } elseif ($scoreEcheance < $scoreAdversaire) {
                    $stats['p']++;
                    if (count($stats['forme']) < 5) $stats['forme'][] = 'P';
                } else {
                    $stats['n']++; $stats['pts'] += 1;
                    if (count($stats['forme']) < 5) $stats['forme'][] = 'N';
                }
            }
            $stats['db'] = $stats['bp'] - $stats['bc'];
            return (object) $stats;
        })->sortByDesc(fn($team) => [$team->pts, $team->db, $team->bp])->values();
    }



    public function render()
    {
        // 0. RÉCUPÉRATION DE LA SAISON (Priorité à l'active, sinon la dernière)
        $activeSeason = \App\Models\Season::where('is_active', true)->first()
                     ?? \App\Models\Season::latest()->first();

        $seasonId = $activeSeason?->id;

        // 1. CALCUL DU CLASSEMENT (Filtré par Season ID)
        $equipes = Equipe::where('est_actif', true)
            ->with([
                'gamesDomicile' => fn($q) => $q->where('statut', 'termine')->where('season_id', $seasonId),
                'gamesExterieur' => fn($q) => $q->where('statut', 'termine')->where('season_id', $seasonId)
            ])
            ->get();

        $standingsCollection = $equipes->map(function ($equipe) {
            $stats = [
                'id'    => $equipe->id,
                'nom'   => $equipe->nom,
                'sigle' => $equipe->sigle,
                'logo'  => $equipe->logo,
                'mj' => 0, 'g' => 0, 'n' => 0, 'p' => 0,
                'bp' => 0, 'bc' => 0, 'pts' => 0,
                'forme' => []
            ];

            $matchs = $equipe->gamesDomicile->concat($equipe->gamesExterieur)->sortByDesc('joue_le');

            foreach ($matchs as $game) {
                $isA = $game->equipe_a_id === $equipe->id;
                $scoreEcheance = $isA ? $game->score_a : $game->score_b;
                $scoreAdversaire = $isA ? $game->score_b : $game->score_a;
                $stats['mj']++;
                $stats['bp'] += $scoreEcheance;
                $stats['bc'] += $scoreAdversaire;

                if ($scoreEcheance > $scoreAdversaire) {
                    $stats['g']++; $stats['pts'] += 3;
                    if (count($stats['forme']) < 5) $stats['forme'][] = 'G';
                } elseif ($scoreEcheance < $scoreAdversaire) {
                    $stats['p']++;
                    if (count($stats['forme']) < 5) $stats['forme'][] = 'P';
                } else {
                    $stats['n']++; $stats['pts'] += 1;
                    if (count($stats['forme']) < 5) $stats['forme'][] = 'N';
                }
            }
            $stats['db'] = $stats['bp'] - $stats['bc'];
            $stats['forme'] = array_reverse($stats['forme']);
            return (object) $stats;
        })->sortByDesc(fn($team) => [$team->pts, $team->db, $team->bp])->values();

        // 2. LOGIQUE DE PAGINATION
        $currentPage = LengthAwarePaginator::resolveCurrentPage('pageStandings');
        $perPage = 10;
        $currentItems = $standingsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $standings = new LengthAwarePaginator(
            $currentItems,
            $standingsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'pageStandings']
        );

        // 3. PAGINATION DES BUTEURS (Filtré par Season ID si tes buts sont liés à une saison)
        // Note: Si tes buts sont dans une table 'goals' liée à 'games', withCount('goals')
        // doit être filtré. Si c'est une colonne simple, le truncate saisonnier suffit.
        $topScorers = Player::with('equipe')
            ->withCount(['goals' => fn($q) => $q->whereHas('game', fn($g) => $g->where('season_id', $seasonId))])
            ->orderByDesc('goals_count')
            ->paginate(5, ['*'], 'pageScorers');

        // 4. RETOUR À LA VUE
        return view('livewire.pages.asfm-full-league-standings', [
            'standings' => $standings,
            'fullStandings' => $standingsCollection,
            'topScorers' => $topScorers,
            'activeSeason' => $activeSeason // Pour ton header
        ]);
    }
}
