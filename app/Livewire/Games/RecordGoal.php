<?php
// app/Livewire/Games/RecordGoal.php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Models\Goal;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class RecordGoal extends Component
{
    public Game $game;
    public $equipe_id;
    public $player_id;
    public $minute;
    public $periode = 1;
    public $duree_periode = 35;
    public $temps_additionnel = 0;
    public $derniere_minute_enregistree = 0;

    public function mount()
    {
        $this->updateLastMinute();
    }

    private function updateLastMinute()
    {
        $dernierBut = Goal::where('game_id', $this->game->id)
            ->orderByDesc('periode')
            ->orderByDesc('minute')
            ->orderByDesc('additionnel')
            ->first();

        if ($dernierBut) {
            // On stocke la minute réelle saisie (minute de base + additionnel) pour la validation
            $this->derniere_minute_enregistree = $dernierBut->minute + $dernierBut->additionnel;
        } else {
            $this->derniere_minute_enregistree = 0;
        }
    }

    protected function rules()
    {
        return [
            'equipe_id' => 'required|exists:equipes,id',
            'player_id' => 'required|exists:players,id',
            'minute' => [
                'required', 'integer', 'min:1', 'max:130',
                function ($attribute, $value, $fail) {
                    if ($this->periode == 2 && $value <= $this->duree_periode) {
                        $fail("En 2ème mi-temps, la minute doit être supérieure à {$this->duree_periode}.");
                    }
                    if ($value < $this->derniere_minute_enregistree) {
                        $fail("Incohérence : le dernier but était à la {$this->derniere_minute_enregistree}e minute.");
                    }
                },
            ],
        ];
    }

    public function updatedMinute($value)
    {
        if (!$value || !is_numeric($value)) {
            $this->temps_additionnel = 0;
            return;
        }
        $seuil = $this->periode * $this->duree_periode;
        $this->temps_additionnel = ($value > $seuil) ? ($value - $seuil) : 0;
    }

    /**
     * Bascule vers la 2ème mi-temps et ajuste la minute
     */
    public function passerSecondePeriode()
    {
        $this->periode = 2;
        $this->minute = $this->duree_periode + 1;
        $this->updatedMinute($this->minute);
    }

    public function saveGoal()
    {
        $this->validate();

        DB::transaction(function () {
            $seuil = $this->periode * $this->duree_periode;
            $minute_affichage = ($this->minute > $seuil) ? $seuil : $this->minute;

            // 1. Création du but
            Goal::create([
                'game_id'     => $this->game->id,
                'player_id'   => $this->player_id,
                'equipe_id'   => $this->equipe_id,
                'minute'      => $minute_affichage,
                'additionnel' => $this->temps_additionnel,
                'periode'     => $this->periode,
                'type'        => 'normal', // Valeur par défaut
            ]);

            // 2. Mise à jour du score du match
            $this->equipe_id == $this->game->equipe_a_id
                ? $this->game->increment('score_a')
                : $this->game->increment('score_b');

            // 3. Mise à jour du compteur global du joueur (pour ton Top Buteurs)
            Player::where('id', $this->player_id)->increment('goals');
        });

        $this->derniere_minute_enregistree = $this->minute;
        $this->reset(['player_id', 'minute', 'temps_additionnel']);
        $this->dispatch('goal-added');
        session()->flash('success', 'But validé !');
    }

    public function deleteGoal($goalId)
    {
        $goal = Goal::findOrFail($goalId);

        DB::transaction(function () use ($goal) {
            // Décrémenter le score du match
            $goal->equipe_id == $this->game->equipe_a_id
                ? $this->game->decrement('score_a')
                : $this->game->decrement('score_b');

            // Décrémenter le total du joueur
            Player::where('id', $goal->player_id)->decrement('goals');

            $goal->delete();
        });

        $this->updateLastMinute();
        $this->dispatch('goal-added');
    }

    public function render()
    {
        $players = $this->equipe_id
            ? Player::where('equipe_id', $this->equipe_id)
                ->withCount(['goals' => fn($q) => $q->where('game_id', $this->game->id)])
                ->orderBy('name')
                ->get()
            : collect();

        return view('livewire.games.record-goal', [
            'players' => $players,
            'allGoals' => Goal::where('game_id', $this->game->id)
                ->with('player')
                ->orderByDesc('periode')
                ->orderByDesc('minute')
                ->orderByDesc('additionnel')
                ->get()
        ]);
    }
}
