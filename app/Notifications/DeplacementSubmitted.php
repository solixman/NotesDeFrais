<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DeplacementSubmitted extends Notification
{
    use Queueable;

    public $deplacement;

    public function __construct($deplacement)
    {
        $this->deplacement = $deplacement;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle demande de déplacement')
            ->line("Nouvelle demande de déplacement vers {$this->deplacement->lieu} soumise par {$this->deplacement->utilisateur->nom}.")
            ->action('Voir la demande', url("/deplacements/{$this->deplacement->id}"));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'deplacement_soumis',
            'deplacement_id' => $this->deplacement->id,
            'message' => "Déplacement vers {$this->deplacement->lieu} soumis par {$this->deplacement->utilisateur->nom}.",
        ];
    }
}
