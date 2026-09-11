<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard Prestataire
            </h1>

            <p class="text-gray-600 mt-1">
                Bienvenue dans votre espace prestataire.
            </p>
        </div>


        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

            {{-- Mes services --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-500">

                <p class="text-sm text-gray-500">
                    Mes services
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ \App\Models\Service::where('prestataire_id', auth()->id())->count() }}
                </p>

            </div>


            {{-- Missions disponibles --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">

                <p class="text-sm text-gray-500">
                    Missions disponibles
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ \App\Models\Mission::where('statut', 'ouverte')->count() }}
                </p>

            </div>


            {{-- Mes offres --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">

                <p class="text-sm text-gray-500">
                    Mes offres
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ \App\Models\Offre::where('prestataire_id', auth()->id())->count() }}
                </p>

            </div>

        </div>


        {{-- Résumé --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Dernières offres --}}
            <div class="bg-white rounded-xl shadow">

                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold text-gray-800">
                        Mes dernières offres
                    </h2>
                </div>

                @php
                    $offres = \App\Models\Offre::where('prestataire_id', auth()->id())
                        ->with('mission')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if($offres->isEmpty())

                    <div class="p-6">
                        <p class="text-gray-500">
                            Vous n'avez encore envoyé aucune offre.
                        </p>
                    </div>

                @else

                    <div class="divide-y">

                        @foreach($offres as $offre)

                            <div class="p-5">

                                <div class="flex items-start justify-between gap-4">

                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            {{ $offre->mission->titre ?? 'Mission supprimée' }}
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Prix proposé :
                                            <strong>
                                                {{ number_format($offre->prix_propose, 2, ',', ' ') }} DH
                                            </strong>
                                        </p>
                                    </div>

                                    @php
                                        $offreClasses = match($offre->statut) {
                                            'en_attente' => 'bg-yellow-100 text-yellow-700',
                                            'acceptee' => 'bg-green-100 text-green-700',
                                            'refusee' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $offreClasses }}">
                                        {{ ucfirst(str_replace('_', ' ', $offre->statut)) }}
                                    </span>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>


            {{-- Informations rapides --}}
            <div class="bg-white rounded-xl shadow">

                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold text-gray-800">
                        Votre activité
                    </h2>
                </div>

                <div class="p-6 space-y-5">

                    <div>
                        <p class="text-sm text-gray-500">
                            Offres en attente
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Offre::where('prestataire_id', auth()->id())->where('statut', 'en_attente')->count() }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Offres acceptées
                        </p>

                        <p class="text-2xl font-bold text-green-600 mt-1">
                            {{ \App\Models\Offre::where('prestataire_id', auth()->id())->where('statut', 'acceptee')->count() }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Offres refusées
                        </p>

                        <p class="text-2xl font-bold text-red-600 mt-1">
                            {{ \App\Models\Offre::where('prestataire_id', auth()->id())->where('statut', 'refusee')->count() }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>