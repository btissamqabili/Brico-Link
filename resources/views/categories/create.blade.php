<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter une catégorie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Nouvelle catégorie
                    </h3>

                    <form action="{{ route('categories.store') }}" method="POST">

                        @csrf

                        {{-- Nom --}}
                        <div class="mb-6">
                            <label for="nom"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                Nom de la catégorie
                            </label>

                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="Ex : Plomberie">

                            @error('nom')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-6">
                            <label for="description"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>

                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-md shadow-sm"
                                      placeholder="Description de la catégorie">{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Boutons --}}
                        <div class="flex items-center gap-3">

                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Ajouter
                            </button>

                            <a href="{{ route('categories.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Annuler
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
