<?php

namespace App\Livewire\Dashboard;

use App\Models\{AsfmEquipement, AsfmMember, Contribution, Game, Goal, Player, Season, Equipe};
use App\Models\Standing;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title, Computed};
use Illuminate\Support\Facades\{Artisan, DB};

#[Layout('layouts::dashboard')]
#[Title('ASFM Administrative Dashboard Overview')]
class Dashboard extends Component
{
    // États des Modals
    public bool $showScoreModal = false;
    public bool $showStockModal = false;

    // Propriétés Score
    public $equipe_a_id, $equipe_b_id, $score_a = 0, $score_b = 0;

    // Propriétés Stock (Ajustement rapide)
    public $selectedItemId;
    public $adjustmentAmount = 1;
    public $adjustmentType = 'add'; // 'add' pour Entrée, 'sub' pour Sortie
    public $selectedSeasonId;


    public function mount()
    {
        // Par défaut, on prend la saison active
        $this->selectedSeasonId = Season::where('is_active', true)->value('id')
                                  ?? Season::latest()->value('id');
    }

    // Propriété pour la saison actuellement visionnée (via le filtre)
    #[Computed]
    public function currentSeason()
    {
        return Season::find($this->selectedSeasonId);
    }

    #[Computed]
    public function equipements()
    {
        // On récupère tout le matériel, les plus critiques en premier
        return AsfmEquipement::orderBy('quantite_disponible', 'asc')->get();
    }

    public function adjustStock()
    {
        $this->validate([
            'selectedItemId' => 'required|exists:asfm_equipements,id',
            'adjustmentAmount' => 'required|integer|min:1',
        ]);

        $equipement = AsfmEquipement::find($this->selectedItemId);

        if ($this->adjustmentType === 'add') {
            $equipement->increment('quantite_disponible', $this->adjustmentAmount);
            // Optionnel : on peut aussi incrémenter la quantité totale si c'est un nouvel achat
            // $equipement->increment('quantite_totale', $this->adjustmentAmount);
        } else {
            // Empêche de descendre en dessous de zéro
            $nouvelleQte = max(0, $equipement->quantite_disponible - $this->adjustmentAmount);
            $equipement->update(['quantite_disponible' => $nouvelleQte]);
        }

        $this->reset(['showStockModal', 'selectedItemId', 'adjustmentAmount']);
        $this->dispatch('show-toast', message: 'Inventaire mis à jour avec succès !', type: 'success');
    }

    /*

    |--------------------------------------------------------------------------
    | LOGIQUE FINANCIÈRE
    |--------------------------------------------------------------------------
    */

    /**
     * SECTION 02 : LOGIQUE FINANCIÈRE
     * Récupère les données comparatives via les Scopes du modèle Contribution
     */
    public function getComparisonData()
    {
        $now = now();
        $lastMonth = now()->subMonth();

        return [
            'labels' => [
                $lastMonth->translatedFormat('F'),
                $now->translatedFormat('F')
            ],
            'datasets' => [[
                'label' => 'Total Collecté (FC)',
                'data' => [
                    // Utilisation optimisée des Scopes du modèle
                    Contribution::duMois($lastMonth)->paye()->sum('montant'),
                    Contribution::duMois($now)->paye()->sum('montant'),
                ],
                'backgroundColor' => ['#94a3b8', '#4f46e5'],
                'borderRadius' => 12,
            ]]
        ];
    }

    private function getTauxRecouvrement()
    {
        $totalEquipes = Equipe::where('est_actif', true)->count();
        if ($totalEquipes === 0) return 0;

        $payes = Contribution::whereMonth('mois_concerne', now()->month)
            ->whereYear('mois_concerne', now()->year)
            ->paye()->count();

        return ($payes / $totalEquipes) * 100;
    }


    /**
     * Génère les données comparatives du budget entre la saison choisie et la précédente
     */
     public function getBudgetComparisonData()
     {
         // 1. Récupérer la saison ou la saison active par défaut si l'ID est nul
         $currentSeason = Season::find($this->selectedSeasonId)
                          ?? Season::where('is_active', true)->first();

         // 2. Vérifier si on a bien trouvé une saison avant de continuer
         if (!$currentSeason) {
             return [
                 'current' => 0,
                 'previous' => 0,
                 'growth' => 0
             ];
         }

         $previousSeason = Season::where('start_date', '<', $currentSeason->start_date)
                                 ->orderByDesc('start_date')
                                 ->first();

         $dataCurrent = Contribution::whereBetween('mois_concerne', [$currentSeason->start_date, $currentSeason->end_date])
             ->where('statut', 'paye') // ou votre scope paye()
             ->sum('montant');

         $dataPrevious = 0;
         if ($previousSeason) {
             $dataPrevious = Contribution::whereBetween('mois_concerne', [$previousSeason->start_date, $previousSeason->end_date])
                 ->where('statut', 'paye')
                 ->sum('montant');
         }

         $growth = $dataPrevious > 0 ? (($dataCurrent - $dataPrevious) / $dataPrevious) * 100 : 0;

         return [
             'current' => $dataCurrent,
             'previous' => $dataPrevious,
             'growth' => $growth
         ];
     }


    /*

    |--------------------------------------------------------------------------
    | LOGIQUE SPORTIVE
    |--------------------------------------------------------------------------
    */

    public function saveScore()
    {
        $this->validate([
            'equipe_a_id' => 'required|exists:equipes,id|different:equipe_b_id',
            'equipe_b_id' => 'required|exists:equipes,id',
            'score_a'     => 'required|integer|min:0',
            'score_b'     => 'required|integer|min:0',
        ]);

        $season = Season::where('is_active', true)->first();
        if (!$season) {
            $this->dispatch('show-toast', message: 'Aucune saison active.', type: 'error');
            return;
        }

        Game::create([
            'season_id' => $season->id,
            'equipe_a_id' => $this->equipe_a_id,
            'equipe_b_id' => $this->equipe_b_id,
            'score_a' => $this->score_a,
            'score_b' => $this->score_b,
            'joue_le' => now(),
            'statut' => 'termine',
        ]);

        Artisan::call('app:sync-league-standings');
        $this->reset(['showScoreModal', 'equipe_a_id', 'equipe_b_id', 'score_a', 'score_b']);
        $this->dispatch('show-toast', message: 'Score enregistré et classement mis à jour !', type: 'success');
    }

    #[Computed]
    public function activeSeason()
    {
        return Season::where('is_active', true)->first();
    }

    /**
 * Réinitialise le filtre sur la saison active.
 */
 public function resetToActiveSeason()
 {
     // On utilise la propriété calculée pour récupérer l'ID
     $activeId = $this->activeSeason?->id;

     if ($activeId) {
         $this->selectedSeasonId = $activeId;

         $this->dispatch('notify',
             title: 'Saison Active', // Optionnel selon votre système de notification
             type: 'info',
             message: 'Affichage de la saison active rétabli.'
         );
     }
 }



 public function render()
 {
     $sid = $this->selectedSeasonId;

     // --- STATS SPORTIVES ---
     $matchsTerminesQuery = Game::where('statut', 'termine')->where('season_id', $sid);
     $totalMatchs = $matchsTerminesQuery->count();
     $totalButs   = $matchsTerminesQuery->get()->sum(fn($g) => $g->score_a + $g->score_b);

     // --- STATS FINANCIÈRES ---
     $totalAnnuel = Contribution::totalAnnuel();
     $objectifAnnuel = 10000000;
     $pourcentageObjectif = $objectifAnnuel > 0 ? ($totalAnnuel / $objectifAnnuel) * 100 : 0;

     return view('livewire.dashboard.dashboard', [
         'seasons'       => Season::orderByDesc('start_date')->get(),
         'totalAnnuel'   => $totalAnnuel,
         'totalMensuel'  => Contribution::totalMensuel(),
         'pourcentageObjectif' => $pourcentageObjectif,
         'tauxRecouvrement'    => $this->getTauxRecouvrement(),
         'retardataires'       => Equipe::where('est_actif', true)
             ->whereDoesntHave('contributions', fn($q) =>
                 $q->whereMonth('mois_concerne', now()->month)
                   ->whereYear('mois_concerne', now()->year)
                   ->paye()
             )->get(),

         'stats_counts' => [
             'users'         => \App\Models\User::count(),
             'equipes'       => Equipe::where('est_actif', true)->count(),
             'players'       => Player::count(),
             'members'       => AsfmMember::where('est_actif', true)->count(),
             'equipements'   => AsfmEquipement::count(),
             'alertes_stock' => AsfmEquipement::all()->filter->is_stock_critique->count(),
         ],

         'standings' => Standing::with('equipe')
             ->where('season_id', $sid)
             ->orderByDesc('points')
             ->orderByDesc('goal_difference')
             ->get(),

         'derniersMatchs' => Game::with(['equipeA', 'equipeB'])
             ->where('season_id', $sid)
             ->orderBy('joue_le', 'desc')
             ->take(5)->get(),

         'prochainMatch' => Game::with(['equipeA', 'equipeB'])
             ->where('statut', 'programme')
             ->where('joue_le', '>', now())
             ->where('season_id', $sid)
             ->orderBy('joue_le', 'asc')->first(),

         'recentGoals' => Goal::with(['player', 'equipe', 'game'])
             ->whereHas('game', fn($q) => $q->where('season_id', $sid))
             ->latest()->take(6)->get(),

         'topScorers' => Player::with('equipe')
             ->withCount(['goals' => fn($q) =>
                 $q->whereHas('game', fn($g) => $g->where('season_id', $sid))
             ])->orderByDesc('goals_count')->take(5)->get(),

         'membres'   => AsfmMember::with('equipe')->where('est_actif', true)->latest()->take(5)->get(),
         'totalButs' => $totalButs,
         'ratioButs' => $totalMatchs > 0 ? round($totalButs / $totalMatchs, 1) : 0,
     ]);
 }
}
