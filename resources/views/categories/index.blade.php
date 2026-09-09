<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des catégories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Message de succès --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- En-tête --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">
                            Liste des catégories
                        </h3>

                        <a href="{{ route('categories.create') }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Ajouter une catégorie
                        </a>
                    </div>

                    {{-- Tableau --}}
                    @if ($categories->count())

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-200">

                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-200 px-4 py-3 text-left">
                                            #
                                        </th>

                                        <th class="border border-gray-200 px-4 py-3 text-left">
                                            Nom
                                        </th>

                                        <th class="border border-gray-200 px-4 py-3 text-left">
                                            Description
                                        </th>

                                        <th class="border border-gray-200 px-4 py-3 text-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($categories as $categorie)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-3">
                                                {{ $categorie->id }}
                                            </td>

                                            <td class="border border-gray-200 px-4 py-3">
                                                {{ $categorie->nom }}
                                            </td>

                                            <td class="border border-gray-200 px-4 py-3">
                                                {{ $categorie->description ?? 'Aucune description' }}
                                            </td>

                                            <td class="border border-gray-200 px-4 py-3 text-center">

                                                <a href="{{route('categories.edit', ['category' => $categorie->id]) }}"
                                                   class="text-blue-600 hover:underline mr-3">
                                                    Modifier
                                                </a>

                                                <form action="{{ route('categories.destroy', ['category' => $categorie->id]) }}"
                                                      method="POST"
                                                      class="inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="text-red-600 hover:underline"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                                                        Supprimer
                                                    </button>

                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="p-4 bg-gray-100 rounded text-gray-600">
                            Aucune catégorie disponible.
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout>