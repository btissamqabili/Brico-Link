<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Notifications\NewOffreNotification;
use App\Notifications\OffreAcceptedNotification;
class OffreController extends Controller
{
    /**
     * Afficher les offres reçues pour une mission
     */
    public function recues(Mission $mission)
    {
        // Vérifier que la mission appartient au client connecté
        abort_unless($mission->client_id === auth()->id(), 403);

        // Récupérer les offres avec les prestataires
        $offres = $mission->offres()
            ->with('prestataire')
            ->latest()
            ->get();

        return view('offres.recues', compact('mission', 'offres'));
    }


    /**
     * Envoyer une offre
     */
    public function store(Request $request, Mission $mission)
    {
        abort_if($mission->statut !== 'ouverte', 404);

        abort_unless(auth()->user()->role === 'prestataire', 403);

        $validated = $request->validate([
            'prix_propose' => ['required', 'numeric', 'min:0'],
            'message' => ['nullable', 'string'],
        ]);

        $existingOffre = Offre::where('mission_id', $mission->id)
            ->where('prestataire_id', auth()->id())
            ->exists();

        if ($existingOffre) {
            return back()->with(
                'error',
                'Vous avez déjà proposé une offre pour cette mission.'
            );
        }

        $offre = Offre::create([
            'mission_id' => $mission->id,
            'prestataire_id' => auth()->id(),
            'prix_propose' => $validated['prix_propose'],
            'message' => $validated['message'] ?? null,
            'statut' => 'en_attente',
        ]);

        // Notification au client
        $mission->client->notify(
            new NewOffreNotification($offre)
        );

        return redirect()
            ->route('prestataire.missions.show', $mission)
            ->with('success', 'Votre offre a été envoyée avec succès.');
    }


    /**
     * Accepter une offre
     */
   /**
 * Accepter une offre
 */
public function accept(Offre $offre)
{
    $mission = $offre->mission;

    // Seul le client propriétaire peut accepter
    abort_unless($mission->client_id === auth()->id(), 403);

    // La mission doit être encore ouverte
    abort_if($mission->statut !== 'ouverte', 404);

    // Accepter l'offre sélectionnée
    $offre->update([
        'statut' => 'acceptee',
    ]);

    // Notification au prestataire
    $offre->prestataire->notify(
        new OffreAcceptedNotification($offre)
    );

    // Refuser automatiquement les autres offres
    Offre::where('mission_id', $mission->id)
        ->where('id', '!=', $offre->id)
        ->update([
            'statut' => 'refusee',
        ]);

    // La mission passe en cours
    $mission->update([
        'statut' => 'en_cours',
    ]);

    return back()->with(
        'success',
        'Offre acceptée avec succès. La mission est maintenant en cours.'
    );
}


    /**
     * Refuser une offre
     */
    public function refuse(Offre $offre)
    {
        $mission = $offre->mission;

        abort_unless($mission->client_id === auth()->id(), 403);

        $offre->update([
            'statut' => 'refusee',
        ]);

        return back()->with(
            'success',
            'Offre refusée.'
        );
    }
}