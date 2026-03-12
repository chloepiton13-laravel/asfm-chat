<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     */
    protected $fillable = [
        'equipe_id',
        'montant',
        'mois_concerne' => 'date',
        'statut',
        'reference_paiement',
        'notes',
        'logs' => 'array',
    ];

    /**
     * Conversion automatique des types (Casting).
     */
    protected $casts = [
        'mois_concerne' => 'date',
        'montant'       => 'decimal:2',
        'created_at'    => 'datetime',
    ];

    /*

    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relation : Une contribution appartient à une équipe (sélection).
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }

    /*

    |--------------------------------------------------------------------------
    | SCOPES (REQUÊTES SIMPLIFIÉES)
    |--------------------------------------------------------------------------
    */

    /**
     * Filtre les contributions pour un mois et une année spécifiques.
     */
    public function scopeDuMois(Builder $query, $date = null): void
    {
        $date = $date ?: now();
        $query->whereMonth('mois_concerne', $date->month)
              ->whereYear('mois_concerne', $date->year);
    }

    /**
     * Filtre uniquement les paiements validés.
     */
    public function scopePaye(Builder $query): void
    {
        $query->where('statut', 'paye');
    }

    /*

    |--------------------------------------------------------------------------
    | LOGIQUE MÉTIER / STATISTIQUES
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si une équipe est à jour pour le mois en cours.
     */
    public static function estAJour(int $equipeId): bool
    {
        return self::where('equipe_id', $equipeId)
            ->whereMonth('mois_concerne', now()->month)
            ->whereYear('mois_concerne', now()->year)
            ->where('statut', 'paye')
            ->exists();
    }
    // app/Models/Contribution.php

    /**
     * Filtre uniquement les paiements validés.
     */

    /**
     * Calcule le total des revenus encaissés pour le mois actuel.
     */
    public static function totalMensuel(): float
    {
        return self::whereMonth('mois_concerne', now()->month)
            ->whereYear('mois_concerne', now()->year)
            ->where('statut', 'paye')
            ->sum('montant');
    }

    /**
     * Calcule le total des revenus encaissés pour l'année en cours.
     */
    public static function totalAnnuel(): float
    {
        return self::whereYear('mois_concerne', now()->year)
            ->where('statut', 'paye')
            ->sum('montant');
    }
}
