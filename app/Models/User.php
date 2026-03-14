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

/**
 * ACE BERG ONYX - SYSTÈME CORE
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, SoftDeletes, InteractsWithMedia, TwoFactorAuthenticatable;

    /**
     * Attributs assignables en masse (Whitelist)
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'about',
        'role',          // ACE BERG : admin, manager, staff
        'is_online',     // Status Monitor
        'last_seen_at',  // Terminal Sync
    ];

    /**
     * Attributs à masquer pour la sécurité (Fortify & API)
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes', // Sécurité Onyx
        'two_factor_secret',         // Sécurité Onyx
    ];

    /**
     * Conversion automatique des types (Casts)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_online' => 'boolean',
        'last_seen_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime', // Fortify Confirm
    ];

    /*

    |----------------------------------------------------------------------
    | ACE BERG - LOGIQUE DE RÔLES & ACCÈS
    |----------------------------------------------------------------------
    */

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isManager(): bool { return $this->role === 'manager'; }
    public function isStaff(): bool { return $this->role === 'staff' || empty($this->role); }

    /*

    |----------------------------------------------------------------------
    | MESSAGERIE & CONVERSATIONS
    |----------------------------------------------------------------------
    */

    public function unreadMessagesCount(): int
    {
        return \App\Models\Message::whereHas('conversation', function ($query) {
            $query->whereHas('users', fn($q) => $q->where('users.id', $this->id));
        })
        ->where('user_id', '!=', $this->id)
        ->whereNull('read_at')
        ->count();
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class)
                    ->withPivot('last_read_at', 'role')
                    ->withTimestamps();
    }

    public function messages(): HasMany { return $this->hasMany(Message::class); }

    /*

    |----------------------------------------------------------------------
    | SPATIE MEDIA LIBRARY (AVATARS SYSTÈME)
    |----------------------------------------------------------------------
    */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(150)->height(150)->sharpen(10);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('avatars', 'thumb')
             ?: 'https://ui-avatars.com' . urlencode($this->name) . '&background=050505&color=f59e0b&bold=true';
    }

    /*

    |----------------------------------------------------------------------
    | RELATIONS D'AMITIÉ (ONYX NETWORK)
    |----------------------------------------------------------------------
    */

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')->withTimestamps();
    }

    public function friendRequestsSent(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'pending')->withTimestamps();
    }

    public function friendRequestsReceived(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
                    ->wherePivot('status', 'pending')->withTimestamps();
    }

    public function blockedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'blocked')->withTimestamps();
    }

    /*

    |----------------------------------------------------------------------
    | HELPERS SYSTÈME
    |----------------------------------------------------------------------
    */

    public function isOnline(): bool
    {
        return $this->is_online && $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
    }

    public function isFriendsWith($userId): bool { return $this->friends()->where('friend_id', $userId)->exists(); }
    public function hasPendingRequestTo($userId): bool { return $this->friendRequestsSent()->where('friend_id', $userId)->exists(); }
    public function hasPendingRequestFrom($userId): bool { return $this->friendRequestsReceived()->where('user_id', $userId)->exists(); }
}
