<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Mission;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function dashboard()
    {
        $nombreClients = User::where('role', 'client')->count();

        $nombrePrestataires = User::where('role', 'prestataire')->count();

        $nombreMissions = Mission::count();

        $nombreOffres = Offre::count();

        $nombreEvaluations = Evaluation::count();

        $evaluations = Evaluation::with([
            'client',
            'prestataire',
            'mission',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'nombreClients',
            'nombrePrestataires',
            'nombreMissions',
            'nombreOffres',
            'nombreEvaluations',
            'evaluations'
        ));
    }

    public function evaluations()
    {
        $evaluations = Evaluation::with([
            'client',
            'prestataire',
            'mission',
        ])
            ->latest()
            ->get();

        return view('admin.evaluations.index', compact('evaluations'));
    }

    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroyUser(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}