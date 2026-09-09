<x-app-layout>

```
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mes missions
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            {{-- En-tête --}}
            <div class="flex justify-between items-center mb-6">

                <h3 class="text-lg font-semibold">
                    Mes missions
                </h3>

                <a
                    href="{{ route('missions.create') }}"
                    style="
                        background-color:#4f46e5;
                        color:white;
                        padding:10px 20px;
                        border-radius:6px;
                        font-weight:600;
                        text-decoration:none;
                        display:inline-block;
                    "
                >
                    + Ajouter une mission
                </a>

            </div>

            {{-- Message de succès --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Message d'erreur --}}
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Erreurs de validation --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Liste des missions --}}
            @forelse($missions as $mission)

                <div class="border rounded-lg p-4 mb-4">

                    {{-- Titre --}}
                    <h4 class="text-lg font-bold">
                        {{ $mission->titre }}
                    </h4>

                    {{-- Description --}}
                    <p class="text-gray-600 mt-2">
                        {{ $mission->description }}
                    </p>

                    {{-- Budget --}}
                    @if($mission->budget)
                        <p class="mt-2 font-semibold">
                            Budget : {{ $mission->budget }} DH
                        </p>
                    @endif

                    {{-- Adresse --}}
                    @if($mission->adresse)
                        <p class="mt-2">
                            Adresse : {{ $mission->adresse }}
                        </p>
                    @endif

                    {{-- Statut --}}
                    <p class="mt-2">
                        Statut :

                        <span class="font-semibold">
                            {{ $mission->statut }}
                        </span>
                    </p>

                    {{-- Actions --}}
                    <div
                        style="
                            margin-top:15px;
                            display:flex;
                            gap:10px;
                            flex-wrap:wrap;
                        "
                    >

                        {{-- Modifier --}}
                        <a
                            href="{{ route('missions.edit', $mission) }}"
                            style="
                                background-color:#4f46e5;
                                color:white;
                                padding:8px 16px;
                                border-radius:6px;
                                font-weight:600;
                                text-decoration:none;
                                display:inline-block;
                            "
                        >
                            Modifier
                        </a>

                        {{-- Voir les offres --}}
                        <a
                            href="{{ route('missions.offres', $mission) }}"
                            style="
                                background-color:#059669;
                                color:white;
                                padding:8px 16px;
                                border-radius:6px;
                                font-weight:600;
                                text-decoration:none;
                                display:inline-block;
                            "
                        >
                            Voir les offres
                        </a>

                        {{-- Terminer la mission --}}
                        @if($mission->statut === 'en_cours')

                            <form
                                method="POST"
                                action="{{ route('missions.complete', $mission) }}"
                                style="display:inline-block;"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    onclick="return confirm('Voulez-vous terminer cette mission ?')"
                                    style="
                                        background-color:#16a34a;
                                        color:white;
                                        padding:8px 16px;
                                        border-radius:6px;
                                        font-weight:600;
                                        border:none;
                                        cursor:pointer;
                                    "
                                >
                                    Terminer la mission
                                </button>

                            </form>

                        @endif

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
                                style="
                                    background-color:#dc2626;
                                    color:white;
                                    padding:8px 16px;
                                    border-radius:6px;
                                    font-weight:600;
                                    border:none;
                                    cursor:pointer;
                                "
                            >
                                Supprimer
                            </button>

                        </form>

                    </div>

                    {{-- Évaluation --}}
                    @if($mission->statut === 'terminee')

                        @php
                            $offreAcceptee = $mission->offres->first();

                            $aDejaEvalue = $mission->evaluations
                                ->where('client_id', auth()->id())
                                ->isNotEmpty();
                        @endphp

                        {{-- Mission déjà évaluée --}}
                        @if($aDejaEvalue)

                            <div class="mt-5 border-t pt-4">
                                <p class="text-green-600 font-semibold">
                                    ✓ Vous avez déjà évalué cette mission.
                                </p>
                            </div>

                        {{-- Mission terminée mais aucune offre acceptée --}}
                        @elseif(!$offreAcceptee)

                            <div class="mt-5 border-t pt-4">
                                <p class="text-gray-500">
                                    Cette mission ne peut pas encore être évaluée
                                    car aucun prestataire n'a été associé.
                                </p>
                            </div>

                        {{-- Mission évaluable --}}
                        @else

                            <div class="mt-5 border-t pt-5">

                                <h5 class="text-lg font-semibold mb-4">
                                    Évaluer le prestataire
                                </h5>

                                <form
                                    method="POST"
                                    action="{{ route('evaluations.store', $mission) }}"
                                >

                                    @csrf

                                    {{-- Note --}}
                                    <div class="mb-4">

                                        <label
                                            for="note-{{ $mission->id }}"
                                            class="block font-medium mb-2"
                                        >
                                            Note
                                        </label>

                                        <select
                                            id="note-{{ $mission->id }}"
                                            name="note"
                                            required
                                            class="border-gray-300 rounded-md shadow-sm"
                                        >

                                            <option value="">
                                                Choisir une note
                                            </option>

                                            <option value="1">
                                                1 / 5
                                            </option>

                                            <option value="2">
                                                2 / 5
                                            </option>

                                            <option value="3">
                                                3 / 5
                                            </option>

                                            <option value="4">
                                                4 / 5
                                            </option>

                                            <option value="5">
                                                5 / 5
                                            </option>

                                        </select>

                                    </div>

                                    {{-- Commentaire --}}
                                    <div class="mb-4">

                                        <label
                                            for="commentaire-{{ $mission->id }}"
                                            class="block font-medium mb-2"
                                        >
                                            Commentaire
                                        </label>

                                        <textarea
                                            id="commentaire-{{ $mission->id }}"
                                            name="commentaire"
                                            rows="3"
                                            maxlength="1000"
                                            class="w-full border-gray-300 rounded-md shadow-sm"
                                            placeholder="Votre commentaire..."
                                        ></textarea>

                                    </div>

                                    {{-- Bouton --}}
                                    <button
                                        type="submit"
                                        style="
                                            background-color:#f59e0b;
                                            color:white;
                                            padding:8px 16px;
                                            border-radius:6px;
                                            font-weight:600;
                                            border:none;
                                            cursor:pointer;
                                        "
                                    >
                                        Évaluer
                                    </button>

                                </form>

                            </div>

                        @endif

                    @endif

                </div>

            @empty

                <p class="text-gray-500">
                    Aucune mission publiée.
                </p>

            @endforelse

        </div>

    </div>
</div>
```

</x-app-layout>
