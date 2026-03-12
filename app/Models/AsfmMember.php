<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsfmMember extends Model
{
    use HasFactory;

    // Optionnel : Forcer le nom de la table si Laravel cherche "asfm_members"
    // mais que vous voulez être explicite.
    protected $table = 'asfm_members';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'postnom',
        'photo',
        'fonction',
        'est_actif',
        'email',
        'telephone',
        'equipe_id',
    ];

    /**
     * Relation avec l'équipe
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }
}
