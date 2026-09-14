<x-guest-layout>
    <div class="mb-4 text-sm leading-6 text-[#6F6862]">
        Vérifiez votre adresse email grâce au lien envoyé après votre inscription.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="notice-success mb-4">
            Un nouveau lien de vérification vient d’être envoyé.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm font-semibold text-[#7F2020] underline-offset-4 hover:underline">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
