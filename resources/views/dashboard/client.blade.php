<x-app-layout>
    <div class="page-frame">
        <section class="grid gap-8 border-b border-[#e5dfd4] pb-10 lg:grid-cols-[1.25fr_0.75fr] lg:items-end">
            <div>
                <p class="eyebrow">Espace client · {{ now()->format('d M Y') }}</p>
                <h1 class="display-title mt-4 max-w-2xl">Les bons gestes commencent par la bonne rencontre.</h1>
                <p class="mt-5 max-w-xl text-base leading-7 text-[#6F6862]">Suivez vos demandes, comparez les savoir-faire proposés et gardez chaque étape de votre projet à portée de main.</p>
            </div>
            <div class="relative min-h-[300px] overflow-hidden bg-[#2F2926] p-6 text-white lg:ml-auto lg:max-w-sm">
                <img src="{{ asset('images/heroes/client-renovation.jpg') }}" alt="Artisan réalisant des travaux dans une maison" class="absolute inset-0 h-full w-full object-cover opacity-45">
                <div class="absolute inset-0 bg-[#7F2020]/65"></div>
                <span class="absolute -right-5 -top-8 font-serif text-8xl text-[#C9CAAC]/30">“</span>
                <div class="relative flex h-full flex-col justify-between">
                <p class="eyebrow !text-[#C9CAAC]">Votre prochain geste</p>
                @if($missions->where('statut', 'ouverte')->isNotEmpty())
                    <div><p class="mt-3 font-serif text-xl leading-7 text-white">Votre demande attend peut-être encore le bon artisan.</p><a href="{{ route('missions.index') }}" class="mt-5 inline-flex border-b border-[#C9CAAC] pb-1 text-sm font-bold text-[#C9CAAC]">Suivre mes missions <span class="ml-3">→</span></a></div>
                @else
                    <div><p class="mt-3 font-serif text-xl leading-7 text-white">Un nouveau projet à la maison ? Décrivez-le, on s’occupe de la suite.</p><a href="{{ route('missions.create') }}" class="mt-5 inline-flex border-b border-[#C9CAAC] pb-1 text-sm font-bold text-[#C9CAAC]">Publier une demande <span class="ml-3">→</span></a></div>
                @endif
                </div>
            </div>
        </section>

        <section class="grid gap-8 py-10 lg:grid-cols-[0.72fr_1.28fr]">
            <div>
                <p class="eyebrow">En un regard</p>
                <div class="mt-5 divide-y divide-[#e5dfd4] border-y border-[#e5dfd4]">
                    <div class="flex items-baseline justify-between py-4"><span class="text-sm text-[#6F6862]">Toutes mes missions</span><strong class="font-serif text-3xl">{{ $missions->count() }}</strong></div>
                    <div class="flex items-baseline justify-between py-4"><span class="text-sm text-[#6F6862]">En attente d’offres</span><strong class="font-serif text-3xl text-[#7F2020]">{{ $missions->where('statut', 'ouverte')->count() }}</strong></div>
                    <div class="flex items-baseline justify-between py-4"><span class="text-sm text-[#6F6862]">En cours</span><strong class="font-serif text-3xl text-[#869B7E]">{{ $missions->where('statut', 'en_cours')->count() }}</strong></div>
                </div>
            </div>

            <div class="surface overflow-hidden">
                <div class="flex items-end justify-between border-b border-[#e5dfd4] p-6 sm:p-8">
                    <div><p class="eyebrow">Votre carnet de projets</p><h2 class="mt-2 font-serif text-2xl">Missions récentes</h2></div>
                    <a href="{{ route('missions.index') }}" class="hidden text-sm font-bold text-[#7F2020] sm:block">Tout voir →</a>
                </div>
                @forelse($missions->take(5) as $mission)
                    @php
                        $statusClass = match($mission->statut) {
                            'ouverte' => 'status-open', 'en_cours' => 'status-progress', 'terminee' => 'status-done', 'annulee' => 'status-cancelled', default => 'bg-[#f1eee8] text-[#6F6862]',
                        };
                    @endphp
                    <div class="border-b border-[#e5dfd4] p-6 last:border-0 sm:p-8">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="max-w-xl"><p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#869B7E]">{{ $mission->created_at?->format('d/m/Y') }}</p><h3 class="mt-2 font-serif text-xl">{{ $mission->titre }}</h3><p class="mt-2 text-sm leading-6 text-[#6F6862]">{{ Str::limit($mission->description, 115) }}</p></div>
                            <span class="status-pill {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $mission->statut)) }}</span>
                        </div>
                        <div class="mt-5 flex flex-wrap items-center justify-between gap-3"><span class="text-sm text-[#6F6862]">Budget <strong class="text-[#2F2926]">{{ $mission->budget !== null ? number_format($mission->budget, 2, ',', ' ') . ' DH' : 'À définir' }}</strong></span><a href="{{ route('missions.offres', $mission) }}" class="action-quiet">Voir les offres <span class="ml-2">→</span></a></div>
                    </div>
                @empty
                    <div class="p-10 text-center"><p class="font-serif text-xl">Votre carnet est encore vide.</p><p class="mt-2 text-sm text-[#6F6862]">Décrivez votre premier projet pour rencontrer un artisan de confiance.</p><a href="{{ route('missions.create') }}" class="action-primary mt-6">Créer une mission</a></div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
