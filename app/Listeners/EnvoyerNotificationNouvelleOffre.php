<?php

namespace App\Listeners;

use App\Events\NouvelleOffreCreee;
use App\Notifications\NouvelleOffreNotification;

class EnvoyerNotificationNouvelleOffre
{
    /**
     * Envoyer une notification au client
     * lorsqu'un prestataire crée une nouvelle offre.
     */
    public function handle(NouvelleOffreCreee $event): void
    {
        $offre = $event->offre;

        // Récupérer la mission concernée
        $mission = $offre->mission;

        // Récupérer le client propriétaire de la mission
        $client = $mission->client;

        // Envoyer la notification
        $client->notify(
            new NouvelleOffreNotification(
                $mission->id,
                $offre->prestataire->name,
                (float) $offre->prix_propose
            )
        );
    }
}
