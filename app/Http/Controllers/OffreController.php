<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Mission;
use Illuminate\Http\Request;

class OffreController extends Controller
{
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

        Offre::create([
            'mission_id' => $mission->id,
            'prestataire_id' => auth()->id(),
            'prix_propose' => $validated['prix_propose'],
            'message' => $validated['message'] ?? null,
        ]);

        return redirect()
            ->route('prestataire.missions.show', $mission)
            ->with('success', 'Votre offre a été envoyée avec succès.');
    }

    public function accept(Offre $offre)
    {
        $mission = $offre->mission;

        abort_unless($mission->client_id === auth()->id(), 403);

        $offre->update([
            'statut' => 'acceptee',
        ]);

        return back()->with(
            'success',
            'Offre acceptée avec succès.'
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