<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier mon offre
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-6">
                    {{ $offre->mission->titre }}
                </h3>

                <form method="POST" action="{{ route('offres.update', $offre) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="prix_propose" class="block font-medium mb-2">Prix proposé (DH)</label>
                        <input type="number" name="prix_propose" id="prix_propose" min="0" step="0.01" required
                            value="{{ old('prix_propose', $offre->prix_propose) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('prix_propose') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="delai_execution" class="block font-medium mb-2">Délai d'exécution (jours)</label>
                        <input type="number" name="delai_execution" id="delai_execution" min="1" max="365" required
                            value="{{ old('delai_execution', $offre->delai_execution) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('delai_execution') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="message" class="block font-medium mb-2">Message</label>
                        <textarea name="message" id="message" rows="5" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('message', $offre->message) }}</textarea>
                        @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-semibold">
                            Enregistrer
                        </button>
                        <a href="{{ route('prestataire.missions.show', $offre->mission) }}" class="px-5 py-2 bg-gray-500 text-white rounded-lg font-semibold">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
