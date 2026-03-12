<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipe extends Model
{
    /** @use HasFactory<\Database\Factories\EquipeFactory> */
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     * @var array<int, string>
     */
     // app/Models/Equipe.php

     protected $fillable = [
         'nom', 'sigle', 'logo', 'is_guest', 'est_actif',
         'points', 'matchs_joues', 'buts_pour', 'buts_contre', 'difference_buts'
     ];


    /**
 * Liste les équipes qui n'ont pas encore payé pour le mois actuel.
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


    public function contributions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    /**
     * Casts pour les types de données spécifiques.
     */
    protected $casts = [
        'est_actif' => 'boolean',
        'is_guest' => 'boolean', // <-- AJOUTÉ : Assure que la valeur reste 0 ou 1
    ];

    /**
     * Relation : Une équipe possède plusieurs joueurs.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'equipe_id');
    }

    /**
     * Relation avec les matchs (en tant qu'équipe domicile).
     */
    public function gamesDomicile(): HasMany
    {
        return $this->hasMany(Game::class, 'equipe_a_id');
    }

    /**
     * Relation avec les matchs (en tant qu'équipe extérieur).
     */
    public function gamesExterieur(): HasMany
    {
        return $this->hasMany(Game::class, 'equipe_b_id');
    }

    /**
     * Optionnel : Récupérer tous les matchs (Domicile + Extérieur)
     */
    public function getAllGamesAttribute()
    {
        return $this->gamesDomicile->merge($this->gamesExterieur);
    }
}
