<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'equipe_id',
        'name',
        'age',              // Colonne statique (fallback)
        'is_active',
        'has_licence',
        'goals',            // Nombre total (si dénormalisé)
        'photo',
        'birth_place',
        'birth_date',       // Colonne source pour le calcul de l'âge
        'nationality',
        'profession',
        'address',
        'phone',
        'email',
        'selection_name',
        'position',
        'foot',
        'jersey_number',
        'join_year',
        'previous_club',
        'level',
        'is_fit',
        'identity_document',
        'medical_certificate',
        'other_documents',
    ];

    /**
     * Casts pour assurer que les types de données sont corrects (Carbon, Boolean, Integer).
     */
    protected $casts = [
        'birth_date'      => 'date',    // Transforme automatiquement la DB en objet Carbon
        'age'             => 'integer',
        'is_active'       => 'boolean',
        'has_licence'     => 'boolean',
        'is_fit'          => 'boolean',
        'other_documents' => 'json',
        'goals'           => 'integer',
        'join_year'       => 'integer',
    ];

    /**
     * ACCESSEUR : $player->real_age
     * Calcule l'âge exact en temps réel à partir de la date de naissance.
     * Si la date de naissance est absente, utilise la valeur de la colonne 'age'.
     */
    protected function realAge(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->birth_date) {
                    return $this->birth_date->age; // Utilise la propriété ->age de Carbon
                }
                return $this->age; // Fallback sur la colonne manuelle
            }
        );
    }

    /**
     * RELATION : Un joueur appartient à une équipe.
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }

    /**
     * RELATION : Un joueur possède plusieurs enregistrements de buts.
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * SCOPE : Facilite le tri par âge dans les requêtes.
     * Utilisation : Player::youngestFirst()->get();
     */
    public function scopeYoungestFirst($query)
    {
        // En SQL, une date plus grande (2010) est plus jeune qu'une petite (1990)
        return $query->orderBy('birth_date', 'desc');
    }

    /**
     * SCOPE : Récupérer les meilleurs buteurs.
     */
    public function scopeTopScorers($query, $limit = 5)
    {
        // On trie soit par la colonne goals, soit par le compte de la relation
        return $query->orderByDesc('goals')->take($limit);
    }
}
