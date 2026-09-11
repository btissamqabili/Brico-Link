<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des missions</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead><tr>
                        <th class="px-4 py-3 text-left">Titre</th>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-left">Catégorie</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($missions as $mission)
                            <tr>
                                <td class="px-4 py-3">{{ $mission->titre }}</td>
                                <td class="px-4 py-3">{{ $mission->client->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $mission->categorie->nom ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $mission->statut)) }}</td>
                                <td class="px-4 py-3">{{ $mission->created_at?->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($mission->statut !== 'annulee' && $mission->statut !== 'terminee')
                                        <form method="POST" action="{{ route('admin.missions.cancel', $mission) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Désactiver cette mission ?')" class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm">Désactiver</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucune mission.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-6">{{ $missions->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
