<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NoteValidated extends Notification
{
    use Queueable;

    public $note;

    public function __construct($note)
    {
        $this->note = $note;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre note a été validée')
            ->line("Votre note du {$this->note->date_depense} a été validée.")
            ->action('Voir la note', url("/notes/{$this->note->id}"));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'note_validée',
            'note_id' => $this->note->id,
            'message' => "Votre note a été validée.",
        ];
    }
}
