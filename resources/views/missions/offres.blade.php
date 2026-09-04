<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Offres reçues
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-bold mb-2">
                    {{ $mission->titre }}
                </h3>

                <p class="text-gray-600 mb-6">
                    Les offres reçues pour cette mission
                </p>

                @forelse($offres as $offre)

                    <div class="border rounded-lg p-4 mb-4">

                        <h4 class="text-lg font-bold">
                            {{ $offre->prestataire->name }}
                        </h4>

                        <p class="mt-2">
                            Prix proposé :
                            <strong>{{ $offre->prix_propose }} DH</strong>
                        </p>

                        @if($offre->message)
                            <p class="mt-2 text-gray-600">
                                {{ $offre->message }}
                            </p>
                        @endif

                        <p class="mt-2">
                            Statut :
                            <strong>{{ $offre->statut }}</strong>
                        </p>
@if($offre->statut === 'en_attente')

    <div class="mt-4 flex gap-2">

        <form method="POST"
              action="{{ route('offres.accept', $offre) }}">
            @csrf
            @method('PATCH')

            <button
                type="submit"
                style="background-color:#16a34a;color:white;padding:8px 16px;border-radius:6px;font-weight:600;border:none;cursor:pointer;"
                onclick="return confirm('Voulez-vous accepter cette offre ?')"
            >
                Accepter
            </button>
        </form>

        <form method="POST"
              action="{{ route('offres.refuse', $offre) }}">
            @csrf
            @method('PATCH')

            <button
                type="submit"
                style="background-color:#dc2626;color:white;padding:8px 16px;border-radius:6px;font-weight:600;border:none;cursor:pointer;"
                onclick="return confirm('Voulez-vous refuser cette offre ?')"
            >
                Refuser
            </button>
        </form>

    </div>

@endif
                    </div>

                @empty

                    <p class="text-gray-500">
                        Aucune offre reçue pour le moment.
                    </p>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>