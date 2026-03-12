<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'is_closed', // Ajouté pour la clôture
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_closed'  => 'boolean', // Ajouté
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    // RELATIONSHIPS
    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    // SCOPES (Pour simplifier tes requêtes ailleurs)

    /**
     * Récupère la saison actuellement active
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Récupère les saisons archivées (clôturées)
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where('is_closed', true);
    }
}
