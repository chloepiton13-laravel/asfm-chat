<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    /** @use HasFactory<\Database\Factories\StandingFactory> */
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     */
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

    /**
     * Relation vers la saison.
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Relation vers l'équipe.
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }
}
