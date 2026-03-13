<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Equipe extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'sigle',
        'logo',
        'is_guest',
        'est_actif',
        // Champs de statistiques (souvent mis à jour via Standing)
        'points',
        'matchs_joues',
        'buts_pour',
        'buts_contre',
        'difference_buts'
    ];

    /**
     * Casts pour assurer le typage (Boolean pour les switchs UI).
     */
    protected $casts = [
        'est_actif' => 'boolean',
        'is_guest'  => 'boolean',
    ];

    // --- RELATIONS ---

    /**
     * Une équipe possède plusieurs joueurs.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'equipe_id');
    }

    /**
     * Une équipe a plusieurs contributions (paiements).
     */
    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    /**
     * Matchs joués à domicile (basé sur equipe_a_id).
     */
    public function gamesDomicile(): HasMany
    {
        return $this->hasMany(Game::class, 'equipe_a_id');
    }

    /**
     * Matchs joués à l'extérieur (basé sur equipe_b_id).
     */
    public function gamesExterieur(): HasMany
    {
        return $this->hasMany(Game::class, 'equipe_b_id');
    }

    /**
     * RÉCUPÉRATION DE TOUS LES MATCHS (Domicile + Extérieur)
     * Utilisé pour calculer la "Forme" (V, N, D).
     */
    public function games(): Builder
    {
        // Retourne un Builder pour permettre le chaînage (ex: ->where('status', 'finished'))
        return Game::query()->where(function ($query) {
            $query->where('equipe_a_id', $this->id)
                  ->orWhere('equipe_b_id', $this->id);
        });
    }

    // --- SCOPES & MÉTHODES STATIQUES ---

    /**
     * Liste les équipes n'ayant pas payé pour le mois en cours.
     */
    public static function enRetardDePaiement()
    {
        return self::where('est_actif', true)
            ->whereDoesntHave('contributions', function($query) {
                $query->whereMonth('mois_concerne', now()->month)
                      ->whereYear('mois_concerne', now()->year)
                      ->where('statut', 'paye');
            })->get();
    }

    /**
     * Accesseur optionnel pour fusionner les collections de matchs en mémoire.
     */
    public function getAllGamesAttribute()
    {
        return $this->gamesDomicile->merge($this->gamesExterieur);
    }
}
