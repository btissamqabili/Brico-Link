<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    🔔 Notifications
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Restez informé de l'activité de vos missions et messages.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <span class="text-sm text-gray-500">
                    {{ $notifications->count() }} notification(s)
                </span>

                @if(auth()->user()->unreadNotifications->count() > 0)

                    <a
                        href="{{ route('notifications.readAll') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-lg transition"
                        style="background-color: #7F2020;"
                        onmouseover="this.style.backgroundColor='#681919'"
                        onmouseout="this.style.backgroundColor='#7F2020'"
                    >
                        ✓ Tout marquer comme lu
                    </a>

                @endif

            </div>

        </div>
    </x-slot>


    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">


            {{-- Nombre de notifications non lues --}}
            @if(auth()->user()->unreadNotifications->count() > 0)

                <div
                    class="mb-6 rounded-xl p-4 border"
                    style="background-color: #F6F3EB; border-color: #C9CAAC;"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center text-lg"
                            style="background-color: #7F2020; color: white;"
                        >
                            🔔
                        </div>

                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ auth()->user()->unreadNotifications->count() }}
                                notification(s) non lue(s)
                            </p>

                            <p class="text-sm text-gray-500">
                                Cliquez sur une notification pour consulter son contenu.
                            </p>
                        </div>

                    </div>

                </div>

            @endif


            {{-- Aucune notification --}}
            @if($notifications->isEmpty())

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">

                    <div
                        class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-3xl mb-4"
                        style="background-color: #F6F3EB;"
                    >
                        🔔
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Aucune notification
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Vous n'avez aucune notification pour le moment.
                    </p>

                </div>


            @else

                <div class="space-y-4">

                    @foreach($notifications as $notification)

                        @php
                            $isUnread = is_null($notification->read_at);
                            $type = $notification->type;
                        @endphp


                        <div
                            class="bg-white rounded-2xl shadow-sm border transition hover:shadow-md
                            {{ $isUnread ? 'border-red-100' : 'border-gray-100' }}"
                        >

                            <div class="p-5">

                                <div class="flex items-start gap-4">


                                    {{-- Icône --}}
                                    <div
                                        class="shrink-0 w-11 h-11 rounded-full flex items-center justify-center text-xl"
                                        style="background-color: {{ $isUnread ? '#F6E5E5' : '#F3F3F3' }};"
                                    >

                                        @if($type === 'App\\Notifications\\NewMessageNotification')
                                            💬
                                        @elseif($type === 'App\\Notifications\\NouvelleOffreNotification')
                                            📩
                                        @elseif($type === 'App\\Notifications\\OffreAcceptedNotification')
                                            ✅
                                        @else
                                            🔔
                                        @endif

                                    </div>


                                    {{-- Contenu --}}
                                    <div class="flex-1 min-w-0">

                                        <div class="flex items-center gap-2 flex-wrap">

                                            @if($type === 'App\\Notifications\\NewMessageNotification')

                                                <h3 class="font-semibold text-gray-800">
                                                    Nouveau message
                                                </h3>

                                            @elseif($type === 'App\\Notifications\\NouvelleOffreNotification')

                                                <h3 class="font-semibold text-gray-800">
                                                    Nouvelle offre
                                                </h3>

                                            @elseif($type === 'App\\Notifications\\OffreAcceptedNotification')

                                                <h3 class="font-semibold text-gray-800">
                                                    Offre acceptée
                                                </h3>

                                            @else

                                                <h3 class="font-semibold text-gray-800">
                                                    Notification
                                                </h3>

                                            @endif


                                            @if($isUnread)

                                                <span
                                                    class="px-2 py-1 text-xs font-bold rounded-full"
                                                    style="background-color: #F6E5E5; color: #7F2020;"
                                                >
                                                    NOUVEAU
                                                </span>

                                            @endif

                                        </div>


                                        {{-- Nouveau message --}}
                                        @if($type === 'App\\Notifications\\NewMessageNotification')

                                            <p class="text-sm text-gray-500 mt-1">
                                                De :
                                                <span class="font-medium text-gray-700">
                                                    {{ $notification->data['sender_name'] ?? 'Utilisateur' }}
                                                </span>
                                            </p>

                                            <p class="text-gray-700 mt-3">
                                                {{ $notification->data['message'] ?? 'Vous avez reçu un nouveau message.' }}
                                            </p>


                                        {{-- Nouvelle offre --}}
                                        @elseif($type === 'App\\Notifications\\NouvelleOffreNotification')

                                            <p class="text-gray-700 mt-3">
                                                {{ $notification->data['message'] ?? 'Une nouvelle offre a été reçue.' }}
                                            </p>


                                        {{-- Offre acceptée --}}
                                        @elseif($type === 'App\\Notifications\\OffreAcceptedNotification')

                                            <p class="text-gray-700 mt-3">
                                                {{ $notification->data['message'] ?? 'Votre offre a été acceptée.' }}
                                            </p>


                                        {{-- Autre --}}
                                        @else

                                            <p class="text-gray-700 mt-3">
                                                {{ $notification->data['message'] ?? 'Vous avez une nouvelle notification.' }}
                                            </p>

                                        @endif


                                        <p class="text-xs text-gray-400 mt-3">
                                            {{ $notification->created_at->format('d/m/Y à H:i') }}
                                        </p>

                                    </div>


                                    {{-- Action --}}
                                    <div class="shrink-0">

                                        @if($isUnread)

                                            <a
                                                href="{{ route('notifications.read', $notification->id) }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-lg transition"
                                                style="background-color: #7F2020;"
                                                onmouseover="this.style.backgroundColor='#681919'"
                                                onmouseout="this.style.backgroundColor='#7F2020'"
                                            >
                                                Voir
                                            </a>

                                        @else

                                            <span class="text-sm text-gray-400">
                                                ✓ Lue
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</x-app-layout>