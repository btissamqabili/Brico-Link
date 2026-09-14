<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div><p class="eyebrow">Votre espace</p><h2 class="display-title mt-3">Profil</h2></div>
    </x-slot>

    <div class="page-frame py-8 lg:py-12">

        <div class="mx-auto max-w-4xl space-y-6">

            {{-- ===================================================== --}}
            {{-- INFORMATIONS DU PROFIL --}}
            {{-- ===================================================== --}}

            <div class="surface p-5 sm:p-8">

                <div class="max-w-xl">

                    @include('profile.partials.update-profile-information-form')

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- ÉVALUATIONS DU PRESTATAIRE --}}
            {{-- ===================================================== --}}

            @if(auth()->user()->role === 'prestataire')

                <div class="surface p-5 sm:p-8">

                    <div class="max-w-xl">

                        {{-- Titre --}}
                        <h3 class="eyebrow mb-6">Évaluations reçues</h3>


                        @if($evaluations->count() > 0)

                            {{-- ================================================= --}}
                            {{-- NOTE MOYENNE --}}
                            {{-- ================================================= --}}

                            <div class="mb-8 text-center">

                                <div class="font-serif text-4xl text-[#2F2926]">
                                    {{ number_format($evaluations->avg('note'), 1) }} / 5
                                </div>

                                {{-- Étoiles moyennes --}}
                                <div class="mt-1 text-2xl text-[#7F2020]">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= round($evaluations->avg('note')))
                                            ★
                                        @else
                                            ☆
                                        @endif

                                    @endfor

                                </div>

                                <p class="mt-1 text-sm text-[#6F6862]">

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

                                    <div class="border-b border-[#e5dfd4] pb-4">

                                        {{-- Client + note --}}
                                        <div class="flex justify-between items-center mb-3">

                                            <div>

                                                <p class="font-semibold text-[#2F2926]">

                                                    {{ $evaluation->client->name ?? 'Client' }}

                                                </p>

                                            </div>


                                            {{-- Étoiles --}}
                                            <div class="text-lg text-[#7F2020]">

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

                                            <p class="text-sm leading-6 text-[#6F6862]">

                                                {{ $evaluation->commentaire }}

                                            </p>

                                        @else

                                            <p class="text-sm italic text-[#6F6862]">

                                                Aucun commentaire.

                                            </p>

                                        @endif


                                        {{-- Date --}}
                                        <p class="mt-3 text-xs text-[#6F6862]">

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

            <div class="surface p-5 sm:p-8">

                <div class="max-w-xl">

                    @include('profile.partials.update-password-form')

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- SUPPRESSION DU COMPTE --}}
            {{-- ===================================================== --}}

            <div class="surface p-5 sm:p-8">

                <div class="max-w-xl">

                    @include('profile.partials.delete-user-form')

                </div>

            </div>

        </div>

    </div>

</x-app-layout>