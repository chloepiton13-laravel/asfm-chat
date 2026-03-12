<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Game;
use Illuminate\Support\Facades\Artisan;

class GameScorer extends Component
{
    public function updateScore($gameId, $scoreA, $scoreB)
    {
        $game = Game::find($gameId);
        $game->update([
            'score_a' => $scoreA,
            'score_b' => $scoreB,
            'statut' => 'termine'
        ]);

        // On relance le calcul du classement automatiquement !
        Artisan::call('app:sync-league-standings');

        session()->flash('message', 'Match enregistré et classement mis à jour !');
    }

    public function render()
    {
        return view('livewire.admin.game-scorer', [
            'pendingGames' => Game::where('statut', '!=', 'termine')
                ->with(['equipeA', 'equipeB'])
                ->orderBy('joue_le', 'asc')
                ->get()
        ]);
    }
}
