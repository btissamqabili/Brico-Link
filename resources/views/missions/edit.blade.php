<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier la mission
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Modifier la mission
                </h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('missions.update', $mission) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="titre" class="block font-medium mb-2">
                            Titre
                        </label>

                        <input
                            type="text"
                            id="titre"
                            name="titre"
                            value="{{ old('titre', $mission->titre) }}"
                            required
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium mb-2">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            required
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                        >{{ old('description', $mission->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="categorie_id" class="block font-medium mb-2">
                            Catégorie
                        </label>

                        <select
                            id="categorie_id"
                            name="categorie_id"
                            required
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                        >
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $mission->categorie_id) == $categorie->id)>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="budget" class="block font-medium mb-2">
                            Budget (DH)
                        </label>

                        <input
                            type="number"
                            id="budget"
                            name="budget"
                            value="{{ old('budget', $mission->budget) }}"
                            min="0"
                            step="0.01"
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="adresse" class="block font-medium mb-2">
                            Adresse
                        </label>

                        <input
                            type="text"
                            id="adresse"
                            name="adresse"
                            value="{{ old('adresse', $mission->adresse) }}"
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="photos" class="block font-medium mb-2">Ajouter des photos</label>
                        <input type="file" id="photos" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple>
                        <p class="text-sm text-gray-500 mt-1">Maximum 5 images au total, 5 Mo par image.</p>
                    </div>

                    <div class="mb-6">
                        <label for="date_souhaitee" class="block font-medium mb-2">
                            Date souhaitée
                        </label>

                        <input
                            type="date"
                            id="date_souhaitee"
                            name="date_souhaitee"
                            value="{{ old('date_souhaitee', optional($mission->date_souhaitee)->format('Y-m-d')) }}"
                            min="{{ now()->toDateString() }}"
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                        >
                    </div>

                    <div class="flex items-center gap-3">

                        <button
                            type="submit"
                            style="background-color:#4f46e5;color:white;padding:10px 20px;border-radius:6px;font-weight:600;border:none;cursor:pointer;"
                        >
                            Modifier la mission
                        </button>

                        <a
                            href="{{ route('missions.index') }}"
                            style="background-color:#6b7280;color:white;padding:10px 20px;border-radius:6px;font-weight:600;text-decoration:none;"
                        >
                            Annuler
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>