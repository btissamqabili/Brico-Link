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

            </div>

        </div>
    </div>

</x-app-layout>