<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'equipe_a_id',
        'equipe_b_id',
        'score_a',
        'score_b',
        'joue_le',
        'terrain',
        'statut', // 'programme', 'en_cours', 'termine'
    ];

    /**
     * Casts pour assurer la manipulation des dates et des entiers
     */
    protected $casts = [
        'joue_le' => 'datetime',
        'score_a' => 'integer',
        'score_b' => 'integer',
    ];

    // --- RELATIONS ---

    /**
     * Saison associée au match
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Équipe à domicile
     */
    public function equipeA(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_a_id');
    }

    /**
     * Équipe à l'extérieur
     */
    public function equipeB(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_b_id');
    }

    /**
     * Liste des buts marqués durant le match
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    // --- ACCESSEURS (UI HELPERS) ---

    /**
     * Retourne le terrain ou une valeur par défaut élégante
     * Usage : $game->lieu
     */
    protected function lieu(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->terrain ?: 'Arena Non Définie',
        );
    }

    /**
     * Détermine si le match est en "Live" (commencé mais pas encore terminé)
     * Utile pour les badges pulsants dans la Sidebar ou la Liste
     * Usage : $game->is_live
     */
    protected function isLive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->statut !== 'termine' &&
                          $this->joue_le->isPast() &&
                          $this->joue_le->diffInMinutes(now()) < 120,
        );
    }

    /**
     * Helper pour obtenir le vainqueur (utilisé pour les badges de victoire)
     */
    public function getWinnerId()
    {
        if ($this->statut !== 'termine' || $this->score_a === $this->score_b) return null;
        return $this->score_a > $this->score_b ? $this->equipe_a_id : $this->equipe_b_id;
    }
}
