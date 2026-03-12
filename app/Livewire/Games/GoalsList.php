<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Models\Goal;
use Livewire\Component;
use Livewire\Attributes\On;

class GoalsList extends Component
{
    public Game $game;

    // Écoute l'événement 'goal-added' envoyé par le formulaire pour se rafraîchir
    #[On('goal-added')]
    public function render()
    {
        return view('livewire.games.goals-list', [
            'goals' => $this->game->goals()
                ->with(['player', 'equipe'])
                ->orderBy('minute', 'asc')
                ->get()
        ]);
    }

    public function deleteGoal($goalId)
    {
        $goal = Goal::findOrFail($goalId);

        // Décrémenter le score du match avant de supprimer le but
        if ($goal->equipe_id === $this->game->equipe_a_id) {
            $this->game->decrement('score_a');
        } else {
            $this->game->decrement('score_b');
        }

        $goal->delete();

        // Notifier les autres composants (ex: le score central du parent)
        $this->dispatch('goal-added');
    }
}
