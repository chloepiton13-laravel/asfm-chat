<?php

// app/Livewire/Pages/RecordMatchResultForm.php

namespace App\Livewire\Pages;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title, On};

#[Layout('layouts::dashboard')]
#[Title('Saisie du Résultat')]
class RecordMatchResultForm extends Component
{
    public Game $game;

    public function mount($id)
    {
        $this->game = Game::with(['equipeA', 'equipeB'])->findOrFail($id);
    }

    #[On('goal-added')]
    public function refreshGame()
    {
        $this->game->refresh();
    }

    /**
     * Clôture le match et met à jour le classement de manière atomique
     */
    public function finishGame()
    {
        // On utilise une transaction pour s'assurer que soit TOUT est mis à jour, soit RIEN (en cas d'erreur)
        DB::transaction(function () {
            $scoreA = $this->game->score_a;
            $scoreB = $this->game->score_b;

            // 1. Calcul des points selon le résultat
            if ($scoreA > $scoreB) {
                $this->updateTeamStats($this->game->equipeA, 3, $scoreA, $scoreB); // Victoire A
                $this->updateTeamStats($this->game->equipeB, 0, $scoreB, $scoreA); // Défaite B
            } elseif ($scoreA < $scoreB) {
                $this->updateTeamStats($this->game->equipeA, 0, $scoreA, $scoreB); // Défaite A
                $this->updateTeamStats($this->game->equipeB, 3, $scoreB, $scoreA); // Victoire B
            } else {
                $this->updateTeamStats($this->game->equipeA, 1, $scoreA, $scoreB); // Nul
                $this->updateTeamStats($this->game->equipeB, 1, $scoreB, $scoreA); // Nul
            }

            // 2. Changement de statut du match
            $this->game->update(['statut' => 'termine']);
        });

        session()->flash('status', 'Match clôturé ! Le classement a été mis à jour.');
        return redirect()->route('standings.index');
    }

    /**
     * Met à jour les colonnes de statistiques d'une équipe
     */
    private function updateTeamStats($team, $points, $goalsFor, $goalsAgainst)
    {
        // Utilisation de incrementEach (Laravel 9.x+) pour une seule requête SQL performante
        $team->incrementEach([
            'points' => $points,
            'matchs_joues' => 1,
            'buts_pour' => $goalsFor,
            'buts_contre' => $goalsAgainst,
            'difference_buts' => ($goalsFor - $goalsAgainst),
        ]);
    }

    public function render()
    {
        return view('livewire.pages.record-match-result-form');
    }
}
