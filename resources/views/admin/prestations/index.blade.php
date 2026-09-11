<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des prestations</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead><tr>
                        <th class="px-4 py-3 text-left">Mission</th>
                        <th class="px-4 py-3 text-left">Prestataire</th>
                        <th class="px-4 py-3 text-left">Début</th>
                        <th class="px-4 py-3 text-left">Fin</th>
                        <th class="px-4 py-3 text-left">Montant</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($prestations as $prestation)
                            <tr>
                                <td class="px-4 py-3">{{ $prestation->mission->titre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $prestation->prestataire->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $prestation->date_debut?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $prestation->date_fin?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $prestation->montant ? number_format($prestation->montant, 2, ',', ' ') . ' DH' : '-' }}</td>
                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $prestation->statut)) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucune prestation.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-6">{{ $prestations->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
