<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Dashboard Client
                </h1>

                <p class="text-gray-600 mt-1">
                    Bienvenue dans votre espace client.
                </p>
            </div>

            <a
                href="{{ route('missions.create') }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition"
            >
                + Créer une mission
            </a>

        </div>


        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

            {{-- Total --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-500">

                <p class="text-sm text-gray-500">
                    Total missions
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $missions->count() }}
                </p>

            </div>


            {{-- Ouvertes --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">

                <p class="text-sm text-gray-500">
                    Missions ouvertes
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $missions->where('statut', 'ouverte')->count() }}
                </p>

            </div>


            {{-- En cours --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">

                <p class="text-sm text-gray-500">
                    Missions en cours
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $missions->where('statut', 'en_cours')->count() }}
                </p>

            </div>


            {{-- Terminées --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">

                <p class="text-sm text-gray-500">
                    Missions terminées
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $missions->where('statut', 'terminee')->count() }}
                </p>

            </div>

        </div>


        {{-- Dernières missions --}}
        <div class="bg-white rounded-xl shadow">

            <div class="p-6 border-b">

                <h2 class="text-xl font-bold text-gray-800">
                    Mes dernières missions
                </h2>

            </div>


            @if($missions->isEmpty())

                <div class="p-8 text-center">

                    <p class="text-gray-500 mb-4">
                        Vous n'avez encore créé aucune mission.
                    </p>

                    <a
                        href="{{ route('missions.create') }}"
                        class="inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"
                    >
                        Créer ma première mission
                    </a>

                </div>

            @else

                <div class="divide-y">

                    @foreach($missions->take(5) as $mission)

                        <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            <div>

                                <h3 class="font-semibold text-lg text-gray-800">
                                    {{ $mission->titre }}
                                </h3>

                                <p class="text-gray-500 text-sm mt-1">
                                    {{ Str::limit($mission->description, 100) }}
                                </p>

                                @if($mission->budget !== null)

                                    <p class="text-sm text-gray-600 mt-2">
                                        Budget :
                                        <strong>
                                            {{ number_format($mission->budget, 2, ',', ' ') }} DH
                                        </strong>
                                    </p>

                                @endif

                            </div>


                            <div class="flex items-center gap-3 flex-wrap">

                                {{-- Statut --}}
                                @php
                                    $statusClasses = match($mission->statut) {
                                        'ouverte' => 'bg-blue-100 text-blue-700',
                                        'en_cours' => 'bg-yellow-100 text-yellow-700',
                                        'terminee' => 'bg-green-100 text-green-700',
                                        'annulee' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp

                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses }}">
                                    {{ ucfirst(str_replace('_', ' ', $mission->statut)) }}
                                </span>

                                {{-- Voir les offres --}}
                                <a
                                    href="{{ route('missions.offres', $mission) }}"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition"
                                >
                                    Voir les offres
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</x-app-layout>