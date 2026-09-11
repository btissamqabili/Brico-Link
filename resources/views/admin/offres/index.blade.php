<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des offres</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead><tr>
                        <th class="px-4 py-3 text-left">Mission</th>
                        <th class="px-4 py-3 text-left">Prestataire</th>
                        <th class="px-4 py-3 text-left">Prix</th>
                        <th class="px-4 py-3 text-left">Délai</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($offres as $offre)
                            <tr>
                                <td class="px-4 py-3">{{ $offre->mission->titre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $offre->prestataire->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ number_format($offre->prix_propose, 2, ',', ' ') }} DH</td>
                                <td class="px-4 py-3">{{ $offre->delai_execution ?? '-' }} jour(s)</td>
                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $offre->statut)) }}</td>
                                <td class="px-4 py-3">
                                    @if($offre->statut === 'en_attente')
                                        <form method="POST" action="{{ route('admin.offres.refuse', $offre) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm">Refuser</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucune offre.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-6">{{ $offres->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
