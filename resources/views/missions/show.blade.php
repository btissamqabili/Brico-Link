<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la mission
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-2xl font-bold mb-6">
                    {{ $mission->titre }}
                </h3>

                <div class="mb-4">
                    <p class="font-semibold">Description :</p>
                    <p class="text-gray-600 mt-1">
                        {{ $mission->description }}
                    </p>
                </div>

                @if($mission->budget)
                    <div class="mb-4">
                        <p class="font-semibold">Budget :</p>
                        <p class="mt-1">
                            {{ $mission->budget }} DH
                        </p>
                    </div>
                @endif

                @if($mission->adresse)
                    <div class="mb-4">
                        <p class="font-semibold">Adresse :</p>
                        <p class="mt-1">
                            {{ $mission->adresse }}
                        </p>
                    </div>
                @endif

                <div class="mb-6">
                    <p class="font-semibold">Statut :</p>
                    <p class="mt-1 text-green-600 font-semibold">
                        {{ $mission->statut }}
                    </p>
                </div>

                <a
                    href="{{ route('prestataire.missions.index') }}"
                    style="background-color:#6b7280;color:white;padding:10px 20px;border-radius:6px;font-weight:600;text-decoration:none;display:inline-block;"
                >
                    ← Retour aux missions
                </a>
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="border-t pt-6 mt-6">

    <h3 class="text-lg font-semibold mb-4">
        Proposer mes services
    </h3>

    <form
        method="POST"
        action="{{ route('offres.store', $mission) }}"
    >
        @csrf

        <div class="mb-4">
            <label for="prix_propose" class="block font-medium text-gray-700">
                Prix proposé (DH)
            </label>

            <input
                type="number"
                name="prix_propose"
                id="prix_propose"
                step="0.01"
                min="0"
                value="{{ old('prix_propose') }}"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >

            @error('prix_propose')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="message" class="block font-medium text-gray-700">
                Message
            </label>

            <textarea
                name="message"
                id="message"
                rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                placeholder="Présentez votre proposition au client..."
            >{{ old('message') }}</textarea>

            @error('message')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button
            type="submit"
            style="background-color:#4f46e5;color:white;padding:10px 20px;border-radius:6px;font-weight:600;border:none;cursor:pointer;"
        >
            Proposer mes services
        </button>

    </form>

</div>
            </div>

        </div>
    </div>

</x-app-layout>