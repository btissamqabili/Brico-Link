<section class="space-y-6">
    <header>
        <h2 class="font-serif text-2xl text-[#2F2926]">
            Supprimer le compte
        </h2>

        <p class="mt-2 text-sm leading-6 text-[#6F6862]">
            La suppression est définitive. Vérifiez vos informations avant de continuer.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-serif text-2xl text-[#2F2926]">
                Confirmer la suppression du compte
            </h2>

            <p class="mt-2 text-sm leading-6 text-[#6F6862]">
                Entrez votre mot de passe pour confirmer cette action définitive.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
