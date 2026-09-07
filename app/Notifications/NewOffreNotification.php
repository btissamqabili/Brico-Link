<?php

namespace App\Notifications;

use App\Models\Offre;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOffreNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Offre $offre
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Vous avez reçu une nouvelle offre pour votre mission : '
                . $this->offre->mission->titre,

            'offre_id' => $this->offre->id,

            'mission_id' => $this->offre->mission_id,

            'prestataire_id' => $this->offre->prestataire_id,

            'prix_propose' => $this->offre->prix_propose,
        ];
    }
}