<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Events\NouvelleOffreCreee;
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
        // La mission doit être ouverte
        abort_if($mission->statut !== 'ouverte', 404);

        // Seul un prestataire peut envoyer une offre
        abort_unless(auth()->user()->role === 'prestataire', 403);

        // Validation
        $validated = $request->validate([
            'prix_propose' => ['required', 'numeric', 'min:0'],
            'message' => ['nullable', 'string'],
        ]);

        // Vérifier si le prestataire a déjà proposé une offre
        $existingOffre = Offre::where('mission_id', $mission->id)
            ->where('prestataire_id', auth()->id())
            ->exists();

        if ($existingOffre) {
            return back()->with(
                'error',
                'Vous avez déjà proposé une offre pour cette mission.'
            );
        }

        // Créer l'offre
        $offre = Offre::create([
            'mission_id' => $mission->id,
            'prestataire_id' => auth()->id(),
            'prix_propose' => $validated['prix_propose'],
            'message' => $validated['message'] ?? null,
            'statut' => 'en_attente',
        ]);

        // Déclencher l'événement de nouvelle offre
        event(new NouvelleOffreCreee($offre));

        return redirect()
            ->route('prestataire.missions.show', $mission)
            ->with(
                'success',
                'Votre offre a été envoyée avec succès.'
            );
    }

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

        // Seul le client propriétaire peut refuser
        abort_unless($mission->client_id === auth()->id(), 403);

        // Refuser l'offre
        $offre->update([
            'statut' => 'refusee',
        ]);

        return back()->with(
            'success',
            'Offre refusée.'
        );
    }
}

