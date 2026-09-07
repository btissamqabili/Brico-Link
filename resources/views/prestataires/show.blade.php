<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil du prestataire
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Profil --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">

                <div class="flex items-center gap-6">

                    {{-- Photo --}}
                    <div>
                        @if($prestataire->photo)
                            <img
                                src="{{ asset('storage/' . $prestataire->photo) }}"
                                alt="Photo de {{ $prestataire->name }}"
                                style="width:100px;height:100px;border-radius:50%;object-fit:cover;"
                            >
                        @else
                            <div
                                style="width:100px;height:100px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;"
                            >
                                👤
                            </div>
                        @endif
                    </div>

                    {{-- Informations --}}
                    <div>
                        <h3 class="text-2xl font-bold">
                            {{ $prestataire->name }}
                        </h3>

                        @if($prestataire->description)
                            <p class="text-gray-600 mt-2">
                                {{ $prestataire->description }}
                            </p>
                        @endif

                        @if($prestataire->competences)
                            <p class="mt-2">
                                <strong>Compétences :</strong>
                                {{ $prestataire->competences }}
                            </p>
                        @endif

                        @if($prestataire->experience)
                            <p class="mt-2">
                                <strong>Expérience :</strong>
                                {{ $prestataire->experience }} ans
                            </p>
                        @endif
                    </div>

                </div>

            </div>


            {{-- Évaluations --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-bold mb-6">
                    ⭐ Évaluations
                </h3>

                {{-- Moyenne --}}
                @php
                    $moyenne = $prestataire->evaluationsRecues->avg('note');
                    $nombreEvaluations = $prestataire->evaluationsRecues->count();
                @endphp

                <div class="border rounded-lg p-5 mb-6">

                    <div class="flex items-center gap-4">

                        <div>
                            <p class="text-3xl font-bold">
                                {{ $moyenne ? number_format($moyenne, 1) : '0.0' }}
                                <span class="text-lg text-gray-500">/ 5</span>
                            </p>
                        </div>

                        <div>
                            @if($moyenne)

                                <div class="text-xl">
                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= round($moyenne))
                                            ⭐
                                        @else
                                            ☆
                                        @endif

                                    @endfor
                                </div>

                                <p class="text-gray-500 text-sm">
                                    {{ $nombreEvaluations }}
                                    {{ $nombreEvaluations > 1 ? 'évaluations' : 'évaluation' }}
                                </p>

                            @else

                                <p class="text-gray-500">
                                    Aucune évaluation pour le moment.
                                </p>

                            @endif
                        </div>

                    </div>

                </div>


                {{-- Liste des évaluations --}}
                @forelse($prestataire->evaluationsRecues as $evaluation)

                    <div class="border rounded-lg p-5 mb-4">

                        {{-- Client + note --}}
                        <div class="flex justify-between items-center">

                            <div>
                                <p class="font-semibold">
                                    {{ $evaluation->client->name }}
                                </p>

                                <p class="text-gray-500 text-sm">
                                    {{ $evaluation->created_at->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="text-lg">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $evaluation->note)
                                        ⭐
                                    @else
                                        ☆
                                    @endif

                                @endfor

                            </div>

                        </div>


                        {{-- Note --}}
                        <p class="mt-3 font-semibold">
                            {{ $evaluation->note }}/5
                        </p>


                        {{-- Commentaire --}}
                        @if($evaluation->commentaire)

                            <p class="mt-2 text-gray-600">
                                "{{ $evaluation->commentaire }}"
                            </p>

                        @else

                            <p class="mt-2 text-gray-400 italic">
                                Aucun commentaire.
                            </p>

                        @endif

                    </div>

                @empty

                    <div class="text-center py-8">

                        <p class="text-gray-500">
                            Aucune évaluation pour le moment.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>