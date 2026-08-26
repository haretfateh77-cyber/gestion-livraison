<?php

namespace App\Mail;

use App\Models\Message as MessageModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouveauMessageLivreur extends Mailable
{
    use Queueable, SerializesModels;

    public MessageModel $contactMessage;

    public function __construct(MessageModel $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function build()
    {
        return $this
            ->subject('Nouveau message d\'un livreur - Carrefour')
            ->view('emails.nouveau-message-livreur');
    }
}