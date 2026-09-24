<?php

namespace App\Mail;

use App\Models\Livraison;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LivraisonAffectee extends Mailable
{
    use Queueable, SerializesModels;

    public Livraison $livraison;

    /**
     * Créer une nouvelle instance du mail.
     */
    public function __construct(Livraison $livraison)
    {
        $this->livraison = $livraison;
    }

    /**
     * Sujet du mail.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle livraison affectée',
        );
    }

    /**
     * Contenu du mail.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.livraison_affectee',
        );
    }

    /**
     * Pièces jointes.
     */
    public function attachments(): array
    {
        return [];
    }
}