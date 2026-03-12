<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AsfmEquipement extends Model
{
    /** @use HasFactory<\Database\Factories\AsfmEquipementFactory> */
    use HasFactory;

    /**
     * Nom de la table car il dévie du standard (asfm_equipements)
     */
    protected $table = 'asfm_equipements';

    protected $fillable = [
        'nom',
        'categorie',
        'quantite_totale',
        'quantite_disponible',
        'etat', // 'neuf', 'bon', 'use', 'hors_service'
        'description'
    ];

    /**
     * Conversion automatique des types.
     */
    protected $casts = [
        'quantite_totale' => 'integer',
        'quantite_disponible' => 'integer',
    ];

    /*

    |--------------------------------------------------------------------------
    | LOGIQUE MÉTIER
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si le stock est critique (moins de 20% disponible).
     */
    public function getIsStockCritiqueAttribute(): bool
    {
        if ($this->quantite_totale <= 0) return true;
        return ($this->quantite_disponible / $this->quantite_totale) < 0.2;
    }

    /**
     * Scope pour filtrer par catégorie (Entraînement, Match, Médical).
     */
    public function scopeCategorie(Builder $query, string $type): void
    {
        $query->where('categorie', $type);
    }

    /**
     * Scope pour les équipements nécessitant un renouvellement.
     */
    public function scopeARemplacer(Builder $query): void
    {
        $query->whereIn('etat', ['use', 'hors_service']);
    }
}
