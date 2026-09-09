<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Mission;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function store(Request $request, Mission $mission)
    {
        // 1. Vérifier que la mission appartient au client connecté
        abort_unless($mission->client_id === auth()->id(), 403);

        // 2. Vérifier que la mission est terminée
        if ($mission->statut !== 'terminee') {
            return back()->with(
                'error',
                'Cette mission n’est pas encore terminée.'
            );
        }

        // 3. Vérifier si le client a déjà évalué cette mission
        $dejaEvaluee = Evaluation::where('mission_id', $mission->id)
            ->where('client_id', auth()->id())
            ->exists();

        if ($dejaEvaluee) {
            return back()->with(
                'error',
                'Vous avez déjà évalué cette mission.'
            );
        }

        // 4. Valider les données du formulaire
        $validated = $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        // 5. Récupérer l'offre acceptée
        $offre = $mission->offres()
            ->where('statut', 'acceptee')
            ->first();

        // 6. Vérifier qu'un prestataire est associé
        if (!$offre) {
            return back()->with(
                'error',
                'Aucun prestataire associé à cette mission.'
            );
        }

        // 7. Créer l'évaluation
        Evaluation::create([
            'mission_id' => $mission->id,
            'client_id' => auth()->id(),
            'prestataire_id' => $offre->prestataire_id,
            'note' => $validated['note'],
            'commentaire' => $validated['commentaire'] ?? null,
        ]);

        // 8. Retourner avec message de succès
        return back()->with(
            'success',
            'Votre évaluation a été ajoutée avec succès.'
        );
    }
}