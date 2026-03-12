<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Goal extends Model
{
    /** @use HasFactory<\Database\Factories\GoalFactory> */
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_id',
        'equipe_id',
        'minute',
        'additionnel', // Temps additionnel (ex: +2)
        'periode',    // 1ère ou 2ème mi-temps
        'type',       // 'normal', 'penalty', 'csc'
    ];

    /**
     * Casts pour assurer le typage des données chronologiques
     */
    protected $casts = [
        'minute'      => 'integer',
        'additionnel' => 'integer',
        'periode'     => 'integer',
    ];

    // --- RELATIONS ---

    /**
     * Le match durant lequel le but a été marqué.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Le joueur qui a marqué le but.
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * L'équipe qui a marqué le but.
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }

    // --- ACCESSEURS (UI HELPERS) ---

    /**
     * Formate l'affichage du temps pour l'interface (ex: 35+2')
     * Usage : $goal->full_time
     */
    protected function fullTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->minute . ($this->additionnel > 0 ? '+' . $this->additionnel : '') . "'"
        );
    }

    /**
     * Retourne une icône ou un label selon le type de but
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'penalty' => 'Penalty',
            'csc'     => 'C.S.C',
            default   => 'But'
        };
    }
}
