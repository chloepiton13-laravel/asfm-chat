<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Message extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Attributs assignables.
     * Types possibles : 'text', 'image', 'file', 'video', 'audio', 'system'
     */
    protected $fillable = [
        'user_id',
        'conversation_id',
        'body',
        'type',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Remonte la conversation parente en haut de liste à chaque nouveau message.
     */
    protected $touches = ['conversation'];

    /*

    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /*

    |--------------------------------------------------------------------------
    | SCOPES (FILTRES)
    |--------------------------------------------------------------------------
    */

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeFromUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /*

    |--------------------------------------------------------------------------
    | ACCESSEURS (HELPERS POUR LA VUE)
    |--------------------------------------------------------------------------
    */

    /**
     * Détermine si le message appartient à l'utilisateur connecté.
     */
    public function getIsOwnMessageAttribute(): bool
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Heure formatée (ex: 14:30).
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('H:i');
    }

    /**
     * URL du média principal (si applicable).
     */
    public function getFileUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('attachments');
    }

    /**
     * URL de la miniature (pour les images).
     */
    public function getPreviewUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('attachments', 'preview');
    }

    /*

    |--------------------------------------------------------------------------
    | LOGIQUE MÉTIER
    |--------------------------------------------------------------------------
    */

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    /*

    |--------------------------------------------------------------------------
    | MEDIALIBRARY CONFIG
    |--------------------------------------------------------------------------
    */

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();
    }
}
