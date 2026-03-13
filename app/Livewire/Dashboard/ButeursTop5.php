<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Player;

class ButeursTop5 extends Component
{
    public function render()
    {
        return view('livewire.dashboard.buteurs-top5', [
            // Utilise ton scope personnalisé du modèle Player
            'topScorers' => Player::with('equipe')
                ->topScorers(5)
                ->get()
        ]);
    }
}
