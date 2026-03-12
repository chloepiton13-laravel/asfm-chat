<?php

// app/Livewire/Pages/TopScorers.php

namespace App\Livewire\Pages;

use App\Models\Goal;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Title, Url, On};

#[Layout('layouts::dashboard')]
#[Title('Meilleurs Buteurs')]
class TopScorers extends Component
{
    #[Url(as: 'q')]
    public $search = '';

    public $limit = 5;

    /**
     * Permet de rafraîchir le classement quand un but est ajouté
     * depuis un autre composant (ex: RecordGoal)
     */
    #[On('goal-added')]
    public function refreshScorers()
    {
        // Le simple appel rafraîchit le cycle de vie du composant
    }

    public function showMore()
    {
        $this->limit += 10;
    }

    // app/Livewire/Pages/TopScorers.php

    public function render()
    {
        $allScorers = Goal::query()
            ->select('player_id', DB::raw('count(*) as total_goals'))
            ->with(['player.equipe'])
            // Filtre de recherche sur le nom du joueur ou de l'équipe
            ->whereHas('player', function ($query) {
                $query->where('players.name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('equipe', function($q) {
                          $q->where('equipes.nom', 'like', '%' . $this->search . '%');
                      });
            })
            ->groupBy('player_id')
            ->orderByDesc('total_goals')
            ->get();

        // On prépare les collections pour la vue
        $top5 = $this->search ? collect() : $allScorers->take(5);
        $others = $this->search ? $allScorers : $allScorers->slice(5, $this->limit - 5);

        // Cette variable permet à ton en-tête d'afficher le compteur correct
        $allDisplay = $this->search ? $allScorers : $top5->concat($others);

        return view('livewire.pages.top-scorers', [
            'top5'       => $top5,
            'others'     => $others,
            'allDisplay' => $allDisplay, // Ajouté pour l'en-tête
            'hasMore'    => !$this->search && ($allScorers->count() > $this->limit)
        ]);
    }
}
