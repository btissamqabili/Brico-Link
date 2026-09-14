<section>
    <header>
        <h2 class="font-serif text-2xl text-[#2F2926]">
            Informations personnelles
        </h2>

        <p class="mt-2 text-sm leading-6 text-[#6F6862]">
            Mettez à jour les informations visibles sur votre profil.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nom --}}
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Téléphone --}}
        <div>
            <x-input-label for="telephone" :value="__('Téléphone')" />
            <x-text-input
                id="telephone"
                name="telephone"
                type="text"
                class="mt-1 block w-full"
                :value="old('telephone', $user->telephone)"
            />
            <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
        </div>

        {{-- Adresse --}}
        <div>
            <x-input-label for="adresse" :value="__('Adresse')" />
            <x-text-input
                id="adresse"
                name="adresse"
                type="text"
                class="mt-1 block w-full"
                :value="old('adresse', $user->adresse)"
            />
            <x-input-error class="mt-2" :messages="$errors->get('adresse')" />
        </div>

        {{-- Profil prestataire --}}
        @if ($user->role === 'prestataire')

            {{-- Description --}}
            <div>
                <x-input-label for="description" :value="__('Description')" />

                <textarea
                    id="description"
                    name="description"
                    class="field-control"
                    rows="4"
                >{{ old('description', $user->description) }}</textarea>

                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            {{-- Compétences --}}
            <div>
                <x-input-label for="competences" :value="__('Compétences')" />

                <textarea
                    id="competences"
                    name="competences"
                    class="field-control"
                    rows="3"
                >{{ old('competences', $user->competences) }}</textarea>

                <x-input-error class="mt-2" :messages="$errors->get('competences')" />
            </div>

            {{-- Expérience --}}
            <div>
                <x-input-label for="experience" :value="__('Expérience (années)')" />

                <x-text-input
                    id="experience"
                    name="experience"
                    type="number"
                    min="0"
                    class="mt-1 block w-full"
                    :value="old('experience', $user->experience)"
                />

                <x-input-error class="mt-2" :messages="$errors->get('experience')" />
            </div>

            {{-- Disponibilité --}}
            <div>
                <x-input-label for="disponibilite" :value="__('Disponibilité')" />

                <x-text-input
                    id="disponibilite"
                    name="disponibilite"
                    type="text"
                    placeholder="Ex: Disponible du lundi au vendredi"
                    class="mt-1 block w-full"
                    :value="old('disponibilite', $user->disponibilite)"
                />

                <x-input-error class="mt-2" :messages="$errors->get('disponibilite')" />
            </div>

        @endif
{{-- Photo --}}
<div>
    <x-input-label for="photo" :value="__('Photo')" />

    <input
        id="photo"
        name="photo"
        type="file"
        accept="image/*"
        class="mt-1 block w-full"
    >

    <x-input-error class="mt-2" :messages="$errors->get('photo')" />

    @if ($user->photo)
        <div class="mt-3">
            <img
                src="{{ asset('storage/' . $user->photo) }}"
                alt="Photo de profil"
                class="w-24 h-24 rounded-full object-cover"
            >
        </div>
    @endif
</div>
        {{-- Bouton --}}
        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-[#386047]"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>

    </form>
</section>