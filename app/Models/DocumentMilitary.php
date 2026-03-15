<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class DocumentMilitary extends Model
{
    use HasFactory;

    /**
     * Nom de la table (optionnel si respecte la convention plurielle).
     */
    protected $table = 'documents_military';

    /**
     * Attributs assignables en masse.
     */
    protected $fillable = [
        'user_id',
        'reference_interne',  // Ex: N° d'ordre / Régiment
        'slug',
        'objet',
        'classification',     // Secret Défense, Confidentiel, etc.
        'unite_emetteur',     // Ex: 1er RI, État-Major
        'unite_destinataire',
        'grade_signataire',   // Ex: Colonel, Capitaine
        'nom_signataire',
        'date_signature',
        'priorite_operationnelle', // Flash, Immédiat, Prioritaire
        'corps_message',      // Contenu texte
        'fichier_joint',      // Chemin PDF/Scan
        'statut',             // Archivé, En cours, Transmis
    ];

    /**
     * Cast des types.
     */
    protected function casts(): array
    {
        return [
            'date_signature' => 'date',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Génération automatique du Slug à la création.
     */
    protected static function booted(): void
    {
        static::creating(function ($doc) {
            if (empty($doc->slug)) {
                $doc->slug = Str::slug($doc->objet) . '-' . Str::random(6);
            }
        });
    }

    /**
     * RELATION : Créateur du document (Utilisateur).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SCOPE : Filtrer par niveau de classification.
     */
    public function scopeClassification($query, $level)
    {
        return $query->where('classification', $level);
    }

    /**
     * ACCESSEUR : Formater la référence pour l'affichage officiel.
     */
    public function getFullReferenceAttribute(): string
    {
        return "REF-MIL/" . strtoupper($this->unite_emetteur) . "/" . $this->reference_interne;
    }
}
