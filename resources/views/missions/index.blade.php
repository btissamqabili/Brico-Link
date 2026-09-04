<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes missions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">
                        Mes missions
                    </h3>

                    <a
                        href="{{ route('missions.create') }}"
                        style="background-color:#4f46e5;color:white;padding:10px 20px;border-radius:6px;font-weight:600;text-decoration:none;display:inline-block;"
                    >
                        + Ajouter une mission
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

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
                            <span class="font-semibold">
                                {{ $mission->statut }}
                            </span>
                        </p>

                        {{-- Actions --}}
                        <div style="margin-top:15px; display:flex; gap:10px;">

                            {{-- Modifier --}}
                            <a
                                href="{{ route('missions.edit', $mission) }}"
                                style="background-color:#4f46e5;color:white;padding:8px 16px;border-radius:6px;font-weight:600;text-decoration:none;display:inline-block;"
                            >
                                Modifier
                            </a>

                            {{-- Supprimer --}}
                            <form
                                method="POST"
                                action="{{ route('missions.destroy', $mission) }}"
                                style="display:inline-block;"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette mission ?')"
                                    style="background-color:#dc2626;color:white;padding:8px 16px;border-radius:6px;font-weight:600;border:none;cursor:pointer;"
                                >
                                    Supprimer
                                </button>
                                <a
    href="{{ route('missions.offres', $mission) }}"
    style="background-color:#059669;color:white;padding:8px 16px;border-radius:6px;font-weight:600;text-decoration:none;display:inline-block;"
>
    Voir les offres
</a>
                            </form>

                        </div>

                    </div>

                @empty

                    <p class="text-gray-500">
                        Aucune mission publiée.
                    </p>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>