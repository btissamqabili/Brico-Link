<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function read(string $id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        // Marquer la notification comme lue
        $notification->markAsRead();

        /*
        |--------------------------------------------------------------------------
        | Redirection selon le type de notification
        |--------------------------------------------------------------------------
        */

        // Notification : nouvelle offre reçue par le client
        if (
            $notification->type === 'App\\Notifications\\NouvelleOffreNotification'
        ) {
            return redirect()->route(
                'missions.offres',
                $notification->data['mission_id']
            );
        }

        // Notification : offre acceptée par le client
        if (
            $notification->type === 'App\\Notifications\\OffreAcceptedNotification'
        ) {
            return redirect()->route(
                'prestataire.missions.show',
                $notification->data['mission_id']
            );
        }

        // Notification : nouveau message
        if (
            $notification->type === 'App\\Notifications\\NewMessageNotification'
        ) {
            $message = Message::findOrFail(
                $notification->data['message_id']
            );

            return redirect()->route(
                'conversations.show',
                $message->conversation_id
            );
        }

        // Sécurité : si le type de notification est inconnu
        return redirect()->route('notifications.index');
    }

    public function readAll()
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with(
            'success',
            'Toutes les notifications ont été marquées comme lues.'
        );
    }
}