<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Offre;
use App\Notifications\NouvelleOffreNotification;
use App\Notifications\OffreAcceptedNotification;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function recues(Mission $mission)
    {
        abort_unless($mission->client_id === auth()->id(), 403);

        $offres = $mission->offres()
            ->with('prestataire')
            ->latest()
            ->get();

        return view('offres.recues', compact('mission', 'offres'));
    }

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

        $mission->client->notify(
            new NouvelleOffreNotification($offre)
        );

        return redirect()
            ->route('prestataire.missions.show', $mission)
            ->with(
                'success',
                'Votre offre a été envoyée avec succès.'
            );
    }

    public function accept(Offre $offre)
    {
        $mission = $offre->mission;

        abort_unless($mission->client_id === auth()->id(), 403);
        abort_if($mission->statut !== 'ouverte', 404);

        $offre->update([
            'statut' => 'acceptee',
        ]);

        $offre->prestataire->notify(
            new OffreAcceptedNotification($offre)
        );

        Offre::where('mission_id', $mission->id)
            ->where('id', '!=', $offre->id)
            ->update([
                'statut' => 'refusee',
            ]);

        $mission->update([
            'statut' => 'en_cours',
        ]);

        return back()->with(
            'success',
            'Offre acceptée avec succès. La mission est maintenant en cours.'
        );
    }

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