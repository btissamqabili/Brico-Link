<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Mission;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function store(Request $request, Mission $mission)
    {
        // Vérifier que la mission appartient au client connecté
        abort_unless($mission->client_id === auth()->id(), 403);

        // Vérifier que la mission est terminée
        if ($mission->statut !== 'terminee') {
            return back()->with(
                'error',
                'Cette mission n’est pas encore terminée.'
            );
        }

        // Vérifier si une évaluation existe déjà
        if (
    Evaluation::where('mission_id', $mission->id)
        ->where('client_id', auth()->id())
        ->exists()
) {
    return back()->with(
        'error',
        'Vous avez déjà évalué ce prestataire pour cette mission.'
    );
}

        // Validation
        $validated = $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        // Récupérer l'offre acceptée
        $offre = $mission->offres()
            ->where('statut', 'acceptee')
            ->first();

        if (!$offre) {
            return back()->with(
                'error',
                'Aucun prestataire associé à cette mission.'
            );
        }

        // Créer l'évaluation
        Evaluation::create([
            'mission_id' => $mission->id,
            'client_id' => auth()->id(),
            'prestataire_id' => $offre->prestataire_id,
            'note' => $validated['note'],
            'commentaire' => $validated['commentaire'] ?? null,
        ]);

        return back()->with(
            'success',
            'Votre évaluation a été ajoutée avec succès.'
        );
    }
}