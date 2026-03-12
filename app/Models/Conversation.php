<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_group',
        'group_photo',
        'user_id', // Créateur
        'last_message_content',
        'last_message_at'
    ];

    protected $casts = [
        'is_group' => 'boolean',
        'last_message_at' => 'datetime',
    ];

    /*

    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Tous les participants incluant les données pivot (rôle, lu/non-lu).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role', 'last_read_at')
                    ->withTimestamps();
    }

    /**
     * Tous les messages de la conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Récupère uniquement le dernier message (Optimisé via Laravel).
     */
    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Le créateur/propriétaire de la conversation.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*

    |--------------------------------------------------------------------------
    | SCOPES & LOGIQUE
    |--------------------------------------------------------------------------
    */

    /**
     * Filtre pour n'avoir que les groupes.
     */
    public function scopeGroups($query)
    {
        return $query->where('is_group', true);
    }

    /**
     * Filtre pour les conversations privées (Direct Messages).
     */
    public function scopeDirectMessages($query)
    {
        return $query->where('is_group', false);
    }

    /**
     * Trie par activité la plus récente.
     */
    public function scopeRecent($query)
    {
        return $query->orderByDesc('last_message_at');
    }

    /**
     * Détermine si la conversation contient des messages non-lus pour l'utilisateur connecté.
     */
    public function hasUnreadMessages($user): bool
    {
        $lastRead = $this->users()->where('user_id', $user->id)->first()?->pivot->last_read_at;

        if (!$lastRead) return true;

        return $this->last_message_at > $lastRead;
    }
}
