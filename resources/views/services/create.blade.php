<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un service
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('services.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nom" class="block font-medium text-sm text-gray-700">
                            Nom du service
                        </label>

                        <input
                            id="nom"
                            name="nom"
                            type="text"
                            value="{{ old('nom') }}"
                            class="block mt-1 w-full border-gray-300 rounded-md"
                            required
                        >

                        @error('nom')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            class="block mt-1 w-full border-gray-300 rounded-md"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="prix" class="block font-medium text-sm text-gray-700">
                            Prix
                        </label>

                        <input
                            id="prix"
                            name="prix"
                            type="number"
                            step="0.01"
                            value="{{ old('prix') }}"
                            class="block mt-1 w-full border-gray-300 rounded-md"
                        >

                        @error('prix')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

<button
    type="submit"
    style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer;"
>
    Ajouter le service
</button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>