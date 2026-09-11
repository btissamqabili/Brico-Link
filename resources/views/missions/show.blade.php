<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la mission
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Messages de succès --}}
                @if(session('success'))
                    <div class="mb-6 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Messages d'erreur --}}
                @if(session('error'))
                    <div class="mb-6 p-3 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif


                {{-- ============================= --}}
                {{-- DETAILS DE LA MISSION --}}
                {{-- ============================= --}}

                <h3 class="text-2xl font-bold mb-6">
                    {{ $mission->titre }}
                </h3>

                <div class="mb-4">

                    <p class="font-semibold">
                        Description :
                    </p>

                    <p class="text-gray-600 mt-1">
                        {{ $mission->description }}
                    </p>

                </div>


                @if($mission->budget)

                    <div class="mb-4">

                        <p class="font-semibold">
                            Budget :
                        </p>

                        <p class="mt-1">
                            {{ number_format($mission->budget, 2, ',', ' ') }} DH
                        </p>

                    </div>

                @endif


                @if($mission->adresse)

                    <div class="mb-4">

                        <p class="font-semibold">
                            Adresse :
                        </p>

                        <p class="mt-1">
                            {{ $mission->adresse }}
                        </p>

                    </div>

                @endif


                <div class="mb-6">

                    <p class="font-semibold">
                        Statut :
                    </p>

                    <p class="mt-1 text-green-600 font-semibold">
                        {{ ucfirst(str_replace('_', ' ', $mission->statut)) }}
                    </p>

                </div>


                {{-- ============================= --}}
                {{-- RETOUR AUX MISSIONS --}}
                {{-- ============================= --}}

                <a
                    href="{{ route('prestataire.missions.index') }}"
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
                    ← Retour aux missions
                </a>


                {{-- ============================= --}}
                {{-- PROPOSER UNE OFFRE --}}
                {{-- ============================= --}}

                @if($mission->statut === 'ouverte')

                    @if(!$aUneOffre)

                        <div class="border-t pt-6 mt-6">

                            <h3 class="text-lg font-semibold mb-4">
                                Proposer mes services
                            </h3>

                            <form
                                method="POST"
                                action="{{ route('offres.store', $mission) }}"
                            >

                                @csrf


                                {{-- Prix proposé --}}
                                <div class="mb-4">

                                    <label
                                        for="prix_propose"
                                        class="block font-medium text-gray-700"
                                    >
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


                                {{-- Message de l'offre --}}
                                <div class="mb-4">

                                    <label
                                        for="message"
                                        class="block font-medium text-gray-700"
                                    >
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


                                {{-- Bouton offre --}}
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
                                    Proposer mes services
                                </button>

                            </form>

                        </div>

                    @else

                        <div class="border-t pt-6 mt-6">

                            <div class="p-4 bg-green-100 text-green-700 rounded-lg">
                                <p class="font-semibold">
                                    ✓ Votre offre a déjà été envoyée.
                                </p>

                                <p class="text-sm mt-1">
                                    Vous ne pouvez proposer qu'une seule offre pour cette mission.
                                </p>
                            </div>

                        </div>

                    @endif

                @endif


                {{-- ============================= --}}
                {{-- EVALUATION --}}
                {{-- ============================= --}}

                @if($mission->statut === 'terminee')

                    <div class="mt-8 border-t pt-6">

                        <h3 class="text-lg font-semibold mb-4">
                            ⭐ Évaluer le prestataire
                        </h3>


                        <form
                            method="POST"
                            action="{{ route('evaluations.store', $mission) }}"
                        >

                            @csrf


                            {{-- Note --}}
                            <div class="mb-4">

                                <label
                                    for="note"
                                    class="block font-medium mb-2"
                                >
                                    Note
                                </label>

                                <select
                                    name="note"
                                    id="note"
                                    required
                                    class="border-gray-300 rounded-md shadow-sm w-full"
                                >

                                    <option value="">
                                        Choisir une note
                                    </option>

                                    <option
                                        value="1"
                                        {{ old('note') == 1 ? 'selected' : '' }}
                                    >
                                        ⭐ 1 / 5
                                    </option>

                                    <option
                                        value="2"
                                        {{ old('note') == 2 ? 'selected' : '' }}
                                    >
                                        ⭐⭐ 2 / 5
                                    </option>

                                    <option
                                        value="3"
                                        {{ old('note') == 3 ? 'selected' : '' }}
                                    >
                                        ⭐⭐⭐ 3 / 5
                                    </option>

                                    <option
                                        value="4"
                                        {{ old('note') == 4 ? 'selected' : '' }}
                                    >
                                        ⭐⭐⭐⭐ 4 / 5
                                    </option>

                                    <option
                                        value="5"
                                        {{ old('note') == 5 ? 'selected' : '' }}
                                    >
                                        ⭐⭐⭐⭐⭐ 5 / 5
                                    </option>

                                </select>

                                @error('note')

                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Commentaire --}}
                            <div class="mb-4">

                                <label
                                    for="commentaire"
                                    class="block font-medium mb-2"
                                >
                                    Commentaire
                                </label>

                                <textarea
                                    name="commentaire"
                                    id="commentaire"
                                    rows="4"
                                    required
                                    class="border-gray-300 rounded-md shadow-sm w-full"
                                    placeholder="Donnez votre avis sur le prestataire..."
                                >{{ old('commentaire') }}</textarea>

                                @error('commentaire')

                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Bouton évaluation --}}
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
                                Envoyer mon évaluation
                            </button>

                        </form>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>