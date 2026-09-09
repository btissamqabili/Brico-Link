<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de l'utilisateur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-semibold mb-6">
                    {{ $user->name }}
                </h3>

                <div class="space-y-4">

                    <div>
                        <strong>Nom :</strong>
                        {{ $user->name }}
                    </div>

                    <div>
                        <strong>Email :</strong>
                        {{ $user->email }}
                    </div>

                    <div>
                        <strong>Rôle :</strong>
                        {{ ucfirst($user->role) }}
                    </div>

                    <div>
                        <strong>Téléphone :</strong>
                        {{ $user->telephone ?? '-' }}
                    </div>

                    <div>
                        <strong>Adresse :</strong>
                        {{ $user->adresse ?? '-' }}
                    </div>

                    @if($user->role === 'prestataire')

                        <hr>

                        <h4 class="text-lg font-semibold">
                            Informations professionnelles
                        </h4>

                        <div>
                            <strong>Description :</strong>
                            {{ $user->description ?? '-' }}
                        </div>

                        <div>
                            <strong>Compétences :</strong>
                            {{ $user->competences ?? '-' }}
                        </div>

                        <div>
                            <strong>Expérience :</strong>
                            {{ $user->experience ?? '-' }} ans
                        </div>

                        <div>
                            <strong>Disponibilité :</strong>
                            {{ $user->disponibilite ?? '-' }}
                        </div>

                    @endif

                    <div>
                        <strong>Inscrit le :</strong>
                        {{ $user->created_at?->format('d/m/Y') }}
                    </div>

                </div>

                <div class="mt-8">

                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition">
                        ← Retour
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>