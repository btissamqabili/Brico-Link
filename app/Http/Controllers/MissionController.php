<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Http\Requests\MissionStoreRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\MissionUpdateRequest;
class MissionController extends Controller
{
    public function index()
    {
        $missions = auth()->user()->missions;

        return view('missions.index', compact('missions'));
    }

    public function create()
    {
        return view('missions.create');
    }
    public function edit(Mission $mission)
{
    Gate::authorize('update', $mission);

    return view('missions.edit', compact('mission'));
}
    public function store(MissionStoreRequest $request)
    {
       
          $validated = $request->validated();
        auth()->user()->missions()->create($validated);

        return redirect()
            ->route('missions.index')
            ->with('success', 'Mission créée avec succès.');
    }
   public function update(MissionUpdateRequest $request, Mission $mission)
{
    Gate::authorize('update', $mission);

    $mission->update($request->validated());

    return redirect()
        ->route('missions.index')
        ->with('success', 'Mission modifiée avec succès.');
}
public function destroy(Mission $mission)
{
    Gate::authorize('delete', $mission);

    $mission->delete();

    return redirect()
        ->route('missions.index')
        ->with('success', 'Mission supprimée avec succès.');
}
public function offres(Mission $mission)
{
    abort_unless($mission->client_id === auth()->id(), 403);

    $offres = $mission->offres()
        ->with('prestataire')
        ->latest()
        ->get();

    return view('missions.offres', compact('mission', 'offres'));
}
}