<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DeplacementValidated extends Notification
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
            ->subject('Votre déplacement a été validé')
            ->line("Votre déplacement vers {$this->deplacement->lieu} a été validé.")
            ->action('Voir la demande', url("/deplacements/{$this->deplacement->id}"));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'deplacement_validé',
            'deplacement_id' => $this->deplacement->id,
            'message' => "Votre déplacement vers {$this->deplacement->lieu} a été validé.",
        ];
    }
}
