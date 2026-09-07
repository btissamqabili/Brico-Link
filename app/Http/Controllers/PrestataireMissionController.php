<?php

namespace App\Http\Controllers;

use App\Models\Mission;

class PrestataireMissionController extends Controller
{
    public function index()
    {
        $missions = Mission::where('statut', 'ouverte')
            ->latest()
            ->get();

        return view('missions.disponibles', compact('missions'));
    }

    public function show(Mission $mission)
{
    abort_if($mission->statut !== 'ouverte', 404);

    $mission->load('offres.prestataire');

    return view('missions.show', compact('mission'));
}
}