<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecruitmentApplication extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Les données du formulaire de recrutement.
     */
    public $data;

    /**
     * On reçoit les données ($data) lors de l'appel : new RecruitmentApplication($data)
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Définit l'objet de l'email avec le nom du joueur.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚽ Recrutement ASFM : ' . ($this->data['name'] ?? 'Nouveau Candidat'),
        );
    }

    /**
     * Définit le template Markdown à utiliser.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recruitment',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
