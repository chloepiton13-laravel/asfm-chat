<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, SoftDeletes, InteractsWithMedia, TwoFactorAuthenticatable;

    // Attributs assignables en masse
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'about',
        'is_online',
        'last_seen_at',
    ];

    /**
     * Compte les messages non lus pour l'utilisateur connecté.
     * On exclut les messages dont il est lui-même l'auteur (user_id != id).
     */
    public function unreadMessagesCount(): int
    {
        return \App\Models\Message::whereHas('conversation', function ($query) {
            $query->whereHas('users', function ($q) {
                $q->where('users.id', $this->id);
            });
        })
        ->where('user_id', '!=', $this->id) // On ne compte pas nos propres messages
        ->whereNull('read_at')              // Uniquement ceux qui n'ont pas de date de lecture
        ->count();
    }

    // Attributs à masquer
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    // Conversion automatique des types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_online' => 'boolean',
        'last_seen_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /*
    |----------------------------------------------------------------------
    | Spatie Media Library (Gestion des avatars)
    |----------------------------------------------------------------------
    */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
             ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(150)
             ->height(150)
             ->sharpen(10);
    }

    // Getter pour l'avatar
    public function getAvatarUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('avatars', 'thumb')
             ?: 'https://ui-avatars.com' . urlencode($this->name) . '&background=random&color=fff';
    }

    /*
    |----------------------------------------------------------------------
    | Relations de conversations (avec les utilisateurs)
    |----------------------------------------------------------------------
    */

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class)
                    ->withPivot('last_read_at', 'role')
                    ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /*
    |----------------------------------------------------------------------
    | Gestion des relations d'amitié (Demande, Blocage, etc.)
    |----------------------------------------------------------------------
    */

    /**
     * Les amis acceptés de l'utilisateur.
     */
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }

    /**
     * Demandes d'amis envoyées (en attente).
     */
    public function friendRequestsSent(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * Demandes d'amis reçues (en attente).
     */
    public function friendRequestsReceived(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * Utilisateurs bloqués.
     */
    public function blockedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'blocked')
                    ->withTimestamps();
    }

    /*
    |----------------------------------------------------------------------
    | Helpers (Méthodes utilitaires pour simplifier le code)
    |----------------------------------------------------------------------
    */

    /**
     * Vérifie si l'utilisateur est en ligne (dans les 5 dernières minutes).
     */
    public function isOnline(): bool
    {
        return $this->is_online && $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
    }

    /**
     * Vérifie si une demande d'ami est en attente.
     */
    public function hasPendingRequestTo($userId): bool
    {
        return $this->friendRequestsSent()->where('friend_id', $userId)->exists();
    }

    /**
     * Vérifie si l'utilisateur est ami avec un autre.
     */
    public function isFriendsWith($userId): bool
    {
        return $this->friends()->where('friend_id', $userId)->exists();
    }

    /**
     * Vérifie si l'utilisateur a une demande d'ami en attente.
     */
    public function hasPendingRequestFrom($userId): bool
    {
        return $this->friendRequestsReceived()->where('user_id', $userId)->exists();
    }
}
