<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Administrateur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Clients</p>
                    <p class="text-3xl font-bold">
                        {{ $nombreClients }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Prestataires</p>
                    <p class="text-3xl font-bold">
                        {{ $nombrePrestataires }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Missions</p>
                    <p class="text-3xl font-bold">
                        {{ $nombreMissions }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Offres</p>
                    <p class="text-3xl font-bold">
                        {{ $nombreOffres }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Évaluations</p>
                    <p class="text-3xl font-bold">
                        {{ $nombreEvaluations }}
                    </p>
                </div>

            </div>
            {{-- Dernières évaluations --}}
            <div class="mt-8 bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Dernières évaluations
                    </h3>

                    @if($evaluations->isEmpty())

                        <p class="text-gray-500">
                            Aucune évaluation trouvée.
                        </p>

                    @else

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200">

                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left">Client</th>
                                        <th class="px-4 py-3 text-left">Prestataire</th>
                                        <th class="px-4 py-3 text-left">Mission</th>
                                        <th class="px-4 py-3 text-left">Note</th>
                                        <th class="px-4 py-3 text-left">Date</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">

                                    @foreach($evaluations as $evaluation)

                                        <tr>
                                            <td class="px-4 py-3">
                                                {{ $evaluation->client->name ?? 'N/A' }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $evaluation->prestataire->name ?? 'N/A' }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $evaluation->mission->titre ?? 'N/A' }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $evaluation->note }}/5
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $evaluation->created_at?->format('d/m/Y') }}
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>

