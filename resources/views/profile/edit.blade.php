<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===================================================== --}}
            {{-- INFORMATIONS DU PROFIL --}}
            {{-- ===================================================== --}}

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="max-w-xl">

                    @include('profile.partials.update-profile-information-form')

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- ÉVALUATIONS DU PRESTATAIRE --}}
            {{-- ===================================================== --}}

            @if(auth()->user()->role === 'prestataire')

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <div class="max-w-xl">

                        {{-- Titre --}}
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">
                            ⭐ Évaluations
                        </h3>


                        @if($evaluations->count() > 0)

                            {{-- ================================================= --}}
                            {{-- NOTE MOYENNE --}}
                            {{-- ================================================= --}}

                            <div class="mb-8 text-center">

                                <div class="text-3xl font-bold text-gray-800">
                                    {{ number_format($evaluations->avg('note'), 1) }} / 5
                                </div>

                                {{-- Étoiles moyennes --}}
                                <div class="text-yellow-500 text-2xl mt-1">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= round($evaluations->avg('note')))
                                            ★
                                        @else
                                            ☆
                                        @endif

                                    @endfor

                                </div>

                                <p class="text-sm text-gray-500 mt-1">

                                    {{ $evaluations->count() }}

                                    {{ $evaluations->count() > 1
                                        ? 'évaluations'
                                        : 'évaluation'
                                    }}

                                </p>

                            </div>


                            {{-- ================================================= --}}
                            {{-- LISTE DES ÉVALUATIONS --}}
                            {{-- ================================================= --}}

                            <div class="space-y-4">

                                @foreach($evaluations as $evaluation)

                                    <div class="border border-gray-200 rounded-lg p-4">

                                        {{-- Client + note --}}
                                        <div class="flex justify-between items-center mb-3">

                                            <div>

                                                <p class="font-semibold text-gray-800">

                                                    {{ $evaluation->client->name ?? 'Client' }}

                                                </p>

                                            </div>


                                            {{-- Étoiles --}}
                                            <div class="text-yellow-500 text-lg">

                                                @for($i = 1; $i <= 5; $i++)

                                                    @if($i <= $evaluation->note)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif

                                                @endfor

                                            </div>

                                        </div>


                                        {{-- Commentaire --}}
                                        @if($evaluation->commentaire)

                                            <p class="text-gray-600 text-sm">

                                                {{ $evaluation->commentaire }}

                                            </p>

                                        @else

                                            <p class="text-gray-400 text-sm italic">

                                                Aucun commentaire.

                                            </p>

                                        @endif


                                        {{-- Date --}}
                                        <p class="text-xs text-gray-400 mt-3">

                                            {{ $evaluation->created_at->format('d/m/Y') }}

                                        </p>

                                    </div>

                                @endforeach

                            </div>


                        @else

                            {{-- Aucune évaluation --}}
                            <div class="text-center py-6">

                                <div class="text-gray-400 text-4xl mb-3">
                                    ⭐
                                </div>

                                <p class="text-gray-500">
                                    Aucune évaluation pour le moment.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            @endif


            {{-- ===================================================== --}}
            {{-- MOT DE PASSE --}}
            {{-- ===================================================== --}}

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="max-w-xl">

                    @include('profile.partials.update-password-form')

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- SUPPRESSION DU COMPTE --}}
            {{-- ===================================================== --}}

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="max-w-xl">

                    @include('profile.partials.delete-user-form')

                </div>

            </div>

        </div>

    </div>

</x-app-layout>