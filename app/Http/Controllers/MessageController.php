<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $userId = auth()->id();

        // Vérifier que l'utilisateur appartient à la conversation
        abort_unless(
            $conversation->client_id === $userId ||
            $conversation->prestataire_id === $userId,
            403
        );

        $validated = $request->validate([
            'contenu' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'contenu' => $validated['contenu'],
        ]);

        return redirect()->route(
            'conversations.show',
            $conversation
        );
    }
}