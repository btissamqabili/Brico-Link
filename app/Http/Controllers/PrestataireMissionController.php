<?php

namespace App\Http\Controllers;

use App\Models\Mission;

class PrestataireMissionController extends Controller
{
    /**
     * Afficher les missions ouvertes.
     */
    public function index()
    {
        $missions = Mission::where('statut', 'ouverte')
            ->latest()
            ->get();

        return view('missions.disponibles', compact('missions'));
    }

    /**
     * Afficher le détail d'une mission.
     *
     * Un prestataire peut accéder à une mission ouverte
     * ou à une mission pour laquelle il a déjà envoyé une offre.
     */
    public function show(Mission $mission)
    {
        $prestataire = auth()->user();

        $aUneOffre = $mission->offres()
            ->where('prestataire_id', $prestataire->id)
            ->exists();

        abort_unless(
            $mission->statut === 'ouverte' || $aUneOffre,
            404
        );

        $mission->load('offres.prestataire');

        return view(
            'missions.show',
            compact('mission', 'aUneOffre')
        );
    }
}