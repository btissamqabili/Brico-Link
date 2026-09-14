<x-app-layout>
    <div class="page-frame">
        <div class="mx-auto max-w-3xl">
            <div class="border-b border-[#e5dfd4] pb-8">
                <p class="eyebrow">Votre atelier</p>
                <h1 class="display-title mt-3">Modifier le service</h1>
                <p class="mt-3 text-sm leading-6 text-[#6F6862]">Gardez votre présentation claire et à jour pour les prochains projets.</p>
            </div>

            <div class="surface mt-8 p-6 sm:p-9">
                @if($errors->any())
                    <div class="notice-error mb-7">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('services.update', $service) }}" class="grid gap-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nom" class="field-label">Nom du service</label>
                        <input id="nom" name="nom" type="text" value="{{ old('nom', $service->nom) }}" class="field-control" required>
                        @error('nom')<p class="mt-1 text-sm text-[#7F2020]">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description" class="field-label">Description</label>
                        <textarea id="description" name="description" rows="5" class="field-control">{{ old('description', $service->description) }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-[#7F2020]">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="categorie_id" class="field-label">Catégorie</label>
                            <select id="categorie_id" name="categorie_id" class="field-control" required>
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" @selected(old('categorie_id', $service->categorie_id) == $categorie->id)>{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                            @error('categorie_id')<p class="mt-1 text-sm text-[#7F2020]">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="prix" class="field-label">Prix (DH)</label>
                            <input id="prix" name="prix" type="number" step="0.01" min="0" value="{{ old('prix', $service->prix) }}" class="field-control">
                            @error('prix')<p class="mt-1 text-sm text-[#7F2020]">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-[#e5dfd4] pt-6 sm:flex-row">
                        <button type="submit" class="action-primary">Enregistrer les changements</button>
                        <a href="{{ route('services.index') }}" class="action-quiet">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>