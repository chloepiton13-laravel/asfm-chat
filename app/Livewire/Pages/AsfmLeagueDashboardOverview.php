<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Season;
use App\Models\Standing;
use App\Models\Player;
use App\Models\Game;

#[Layout('layouts.app')]
class AsfmLeagueDashboardOverview extends Component
{
    public $season;
    public $tab = 'classement';

    public function mount()
    {
        // Récupération de la saison active
        $this->season = Season::where('is_active', true)->first();
    }

    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    /**
     * Classement complet avec toutes les colonnes techniques
     */
    #[Computed]
    public function standings()
    {
        if (!$this->season) return collect();

        return Standing::with('equipe')
            ->where('season_id', $this->season->id)
            ->orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for')
            ->get();
    }

    /**
     * Meilleurs buteurs de la ligue
     */
    #[Computed]
    public function topScorers()
    {
        return Player::with('equipe')
            ->where('goals', '>', 0)
            ->orderByDesc('goals')
            ->take(5)
            ->get();
    }

    /**
     * Prochains matchs (à venir)
     */
    #[Computed]
    public function upcomingGames()
    {
        if (!$this->season) return collect();

        return Game::with(['equipeA', 'equipeB'])
            ->where('season_id', $this->season->id)
            ->whereIn('statut', ['scheduled', 'en_attente'])
            ->orderBy('joue_le', 'asc')
            ->take(3)
            ->get();
    }

    /**
     * Résultats récents (matchs terminés)
     */
    #[Computed]
    public function recentResults()
    {
        if (!$this->season) return collect();

        return Game::with(['equipeA', 'equipeB'])
            ->where('season_id', $this->season->id)
            ->where('statut', 'termine')
            ->orderByDesc('joue_le')
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.asfm-league-dashboard-overview');
    }
}
