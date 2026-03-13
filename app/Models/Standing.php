<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'equipe_id',
        'played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
    ];

    // --- RELATIONS ---

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }

    // --- ACCESSEURS (UI HELPERS) ---

    /**
     * Génère le tableau de forme (ex: ['V', 'N', 'D', 'V', 'V'])
     * Basé sur les 5 derniers matchs de l'équipe associée.
     */
    protected function formArray(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->equipe) return [];

                // Récupère les 5 derniers matchs avec score complet, triés par joue_le
                $games = $this->equipe->games()
                    ->whereNotNull('score_a')
                    ->whereNotNull('score_b')
                    ->orderByDesc('joue_le') // <-- corrigé
                    ->take(5)
                    ->get();

                return $games->map(function ($game) {
                    $isTeamA = $game->equipe_a_id === $this->equipe_id;

                    $myScore = $isTeamA ? $game->score_a : $game->score_b;
                    $oppScore = $isTeamA ? $game->score_b : $game->score_a;

                    if ($myScore > $oppScore) return 'V'; // Victoire
                    if ($myScore < $oppScore) return 'D'; // Défaite
                    return 'N'; // Nul
                })->toArray();
            }
        );
    }
}
