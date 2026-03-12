<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Friend extends Model
{
    use HasFactory;

    /**
     * Les attributs que l'on peut remplir.
     * Status possibles : 'pending', 'accepted', 'blocked', 'declined'
     */
    protected $fillable = [
        'user_id',      // L'expéditeur
        'friend_id',    // Le destinataire
        'status',
        'accepted_at'
    ];

    /**
     * Conversion automatique des dates.
     */
    protected $casts = [
        'accepted_at' => 'datetime',
        'status' => 'string',
    ];

    /*

    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * L'utilisateur qui a initié la demande (Expéditeur).
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * L'utilisateur qui reçoit la demande (Destinataire).
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    /*

    |--------------------------------------------------------------------------
    | SCOPES (Filtres de requêtes)
    |--------------------------------------------------------------------------
    */

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', 'accepted');
    }

    public function scopeBlocked(Builder $query): Builder
    {
        return $query->where('status', 'blocked');
    }

    /*

    |--------------------------------------------------------------------------
    | LOGIQUE MÉTIER (Helpers)
    |--------------------------------------------------------------------------
    */

    /**
     * Accepter une demande d'ami.
     */
    public function accept(): bool
    {
        return $this->update([
            'status' => 'accepted',
            'accepted_at' => now()
        ]);
    }

    /**
     * Refuser ou supprimer une demande d'ami.
     */
    public function decline(): bool
    {
        return $this->delete();
    }

    /**
     * Bloquer un utilisateur.
     */
    public function block(): bool
    {
        return $this->update([
            'status' => 'blocked',
            'accepted_at' => null
        ]);
    }

    /**
     * Vérifie si la relation est acceptée.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Vérifie si la demande est toujours en attente.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
