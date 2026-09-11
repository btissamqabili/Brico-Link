<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des évaluations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Toutes les évaluations
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
                                        <th class="px-4 py-3 text-left">
                                            Client
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Prestataire
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Mission
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Note
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Commentaire
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Date
                                        </th>

                                        <th class="px-4 py-3 text-left">Action</th>
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
                                                ⭐ {{ $evaluation->note }}/5
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $evaluation->commentaire ?? 'Aucun commentaire' }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $evaluation->created_at->format('d/m/Y') }}
                                            </td>

                                            <td class="px-4 py-3">
                                                <form method="POST" action="{{ route('admin.evaluations.destroy', $evaluation) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Supprimer cette évaluation ?')" class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm">Supprimer</button>
                                                </form>
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