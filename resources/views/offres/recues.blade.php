<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Offres reçues
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-2xl font-bold mb-6">
                    Offres pour : {{ $mission->titre }}
                </h3>


                {{-- Message de succès --}}
                @if(session('success'))

                    <div class="mb-6 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>

                @endif


                {{-- Message d'erreur --}}
                @if(session('error'))

                    <div class="mb-6 p-3 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>

                @endif


                {{-- ============================= --}}
                {{-- LISTE DES OFFRES --}}
                {{-- ============================= --}}

                @forelse($offres as $offre)

                    <div class="border rounded-lg p-5 mb-5">

                        {{-- Prestataire --}}
                        <div class="flex items-center justify-between mb-4">

                            <div>

                                <h4 class="text-xl font-bold">
                                    {{ $offre->prestataire->name }}
                                </h4>

                                <p class="text-gray-500">
                                    Prestataire
                                </p>

                            </div>


                            {{-- Voir profil --}}
                            <a
                                href="{{ route('prestataires.show', $offre->prestataire->id) }}"
                                style="
                                    background-color:#4f46e5;
                                    color:white;
                                    padding:8px 16px;
                                    border-radius:6px;
                                    font-weight:600;
                                    text-decoration:none;
                                "
                            >
                                Voir le profil
                            </a>

                        </div>


                        {{-- Prix --}}
                        <div class="mb-3">

                            <span class="font-semibold">
                                Prix proposé :
                            </span>

                            {{ $offre->prix_propose }} DH

                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Délai d'exécution :</span>
                            {{ $offre->delai_execution ?? 'Non précisé' }}
                            @if($offre->delai_execution)
                                jour(s)
                            @endif
                        </div>


                        {{-- Message --}}
                        @if($offre->message)

                            <div class="mb-3">

                                <span class="font-semibold">
                                    Message :
                                </span>

                                <p class="text-gray-600 mt-1">
                                    {{ $offre->message }}
                                </p>

                            </div>

                        @endif


                        {{-- Statut --}}
                        <div class="mb-4">

                            <span class="font-semibold">
                                Statut :
                            </span>


                            @if($offre->statut === 'acceptee')

                                <span class="text-green-600 font-semibold">
                                    Acceptée
                                </span>

                            @elseif($offre->statut === 'refusee')

                                <span class="text-red-600 font-semibold">
                                    Refusée
                                </span>

                            @else

                                <span class="text-yellow-600 font-semibold">
                                    En attente
                                </span>

                            @endif

                        </div>


                        {{-- Actions --}}
                        @if($offre->statut === 'en_attente')

                            <div class="flex gap-3">

                                {{-- Accepter --}}
                                <form
                                    method="POST"
                                    action="{{ route('offres.accept', $offre) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Voulez-vous accepter cette offre ?')"
                                        style="
                                            background-color:#16a34a;
                                            color:white;
                                            padding:8px 16px;
                                            border-radius:6px;
                                            border:none;
                                            font-weight:600;
                                            cursor:pointer;
                                        "
                                    >
                                        Accepter
                                    </button>

                                </form>


                                {{-- Refuser --}}
                                <form
                                    method="POST"
                                    action="{{ route('offres.refuse', $offre) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Voulez-vous refuser cette offre ?')"
                                        style="
                                            background-color:#dc2626;
                                            color:white;
                                            padding:8px 16px;
                                            border-radius:6px;
                                            border:none;
                                            font-weight:600;
                                            cursor:pointer;
                                        "
                                    >
                                        Refuser
                                    </button>

                                </form>

                            </div>

                        @endif

                    </div>

                @empty

                    <p class="text-gray-500">
                        Aucune offre reçue pour cette mission.
                    </p>

                @endforelse


                {{-- ===================================== --}}
                {{-- ÉVALUATION --}}
                {{-- ===================================== --}}

                @if($mission->statut === 'terminee')

                    @php
                        $offreAcceptee = $offres->firstWhere('statut', 'acceptee');

                        $evaluationExiste = \App\Models\Evaluation::where('mission_id', $mission->id)
                            ->where('client_id', auth()->id())
                            ->exists();
                    @endphp


                    @if($offreAcceptee)

                        <div class="mt-8 border-t pt-6">

                            <h3 class="text-xl font-bold mb-4">
                                Évaluer le prestataire
                            </h3>


                            {{-- Prestataire accepté --}}
                            <div class="mb-5 p-4 bg-gray-50 rounded-lg">

                                <p class="text-gray-600">
                                    Prestataire :
                                </p>

                                <p class="font-bold text-lg">
                                    {{ $offreAcceptee->prestataire->name }}
                                </p>

                            </div>


                           @if($evaluationExiste)

    @if(!session('success'))

        {{-- Déjà évalué --}}
        <div class="p-4 bg-green-100 text-green-700 rounded-lg">
            ⭐ Vous avez déjà évalué ce prestataire pour cette mission.
        </div>

    @endif

@else

                                {{-- Formulaire d'évaluation --}}
                                <form
                                    method="POST"
                                    action="{{ route('evaluations.store', $mission) }}"
                                >

                                    @csrf


                                    {{-- Note --}}
                                    <div class="mb-5">

                                        <label
                                            for="note"
                                            class="block font-semibold mb-2"
                                        >
                                            Note
                                        </label>

                                        <select
                                            id="note"
                                            name="note"
                                            required
                                            class="border rounded-lg px-3 py-2 w-full"
                                        >

                                            <option value="">
                                                Choisir une note
                                            </option>

                                            <option value="1">
                                                ⭐ 1 - Très mauvais
                                            </option>

                                            <option value="2">
                                                ⭐⭐ 2 - Mauvais
                                            </option>

                                            <option value="3">
                                                ⭐⭐⭐ 3 - Moyen
                                            </option>

                                            <option value="4">
                                                ⭐⭐⭐⭐ 4 - Bon
                                            </option>

                                            <option value="5">
                                                ⭐⭐⭐⭐⭐ 5 - Excellent
                                            </option>

                                        </select>

                                        @error('note')
                                            <p class="text-red-600 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>


                                    {{-- Commentaire --}}
                                    <div class="mb-5">

                                        <label
                                            for="commentaire"
                                            class="block font-semibold mb-2"
                                        >
                                            Commentaire
                                        </label>

                                        <textarea
                                            id="commentaire"
                                            name="commentaire"
                                            rows="4"
                                            maxlength="1000"
                                            class="w-full border rounded-lg px-3 py-2"
                                            placeholder="Donnez votre avis sur le travail du prestataire..."
                                        ></textarea>

                                        @error('commentaire')
                                            <p class="text-red-600 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>


                                    {{-- Envoyer --}}
                                    <button
                                        type="submit"
                                        style="
                                            background-color:#4f46e5;
                                            color:white;
                                            padding:10px 20px;
                                            border-radius:6px;
                                            font-weight:600;
                                            border:none;
                                            cursor:pointer;
                                        "
                                    >
                                        ⭐ Envoyer l'évaluation
                                    </button>

                                </form>

                            @endif

                        </div>

                    @endif

                @endif


                {{-- Retour --}}
                <div class="mt-6">

                    <a
                        href="{{ url()->previous() }}"
                        style="
                            background-color:#6b7280;
                            color:white;
                            padding:10px 20px;
                            border-radius:6px;
                            font-weight:600;
                            text-decoration:none;
                            display:inline-block;
                        "
                    >
                        ← Retour
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>