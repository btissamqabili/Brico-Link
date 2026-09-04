<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Missions disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Missions disponibles
                </h3>

                @forelse($missions as $mission)

                    <div class="border rounded-lg p-4 mb-4">

                        <h4 class="text-lg font-bold">
                            {{ $mission->titre }}
                        </h4>

                        <p class="text-gray-600 mt-2">
                            {{ $mission->description }}
                        </p>

                        @if($mission->budget)
                            <p class="mt-2 font-semibold">
                                Budget : {{ $mission->budget }} DH
                            </p>
                        @endif

                        @if($mission->adresse)
                            <p class="mt-2">
                                Adresse : {{ $mission->adresse }}
                            </p>
                        @endif

                        <p class="mt-2">
                            Statut :
                            <span class="font-semibold text-green-600">
                                {{ $mission->statut }}
                            </span>
                        </p>

                    </div>
<a
    href="{{ route('prestataire.missions.show', $mission) }}"
    style="background-color:#4f46e5;color:white;padding:8px 16px;border-radius:6px;font-weight:600;text-decoration:none;display:inline-block;margin-top:10px;"
>
    Voir les détails
</a>
                @empty

                    <p class="text-gray-500">
                        Aucune mission disponible pour le moment.
                    </p>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>