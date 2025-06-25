<?php


namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NoteSubmitted extends Notification
{
    public $note;

    public function __construct($note)
    {
        $this->note = $note;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send to email + dashboardphp artisan tinker

    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle note de frais soumise')
            ->line("Une nouvelle note de frais a été soumise par {$this->note->utilisateur->nom}")
            ->action('Voir la note', url("/notes/{$this->note->id}"));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'note_soumise',
            'note_id' => $this->note->id,
            'message' => "Nouvelle note soumise par {$this->note->utilisateur->nom}",
        ];
    }
}


