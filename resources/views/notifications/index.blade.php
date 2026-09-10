```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🔔 Notifications
            </h2>

            <span class="text-sm text-gray-500">
                {{ $notifications->count() }} notification(s)
            </span>
            @if(auth()->user()->unreadNotifications->count() > 0)
    <a
        href="{{ route('notifications.readAll') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition"
    >
        ✓ Tout marquer comme lu
    </a>
@endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($notifications->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <div class="text-4xl mb-3">🔔</div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Aucune notification
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Vous n'avez aucune nouvelle notification pour le moment.
                    </p>
                </div>
            @else
                <div class="space-y-4">

                    @foreach($notifications as $notification)
                        <div
                            class="bg-white rounded-xl shadow-sm p-5 border-l-4
                            {{ $notification->read_at ? 'border-gray-300' : 'border-red-700' }}"
                        >
                            <div class="flex items-start justify-between gap-4">

                                <div class="flex-1">

                                    <div class="flex items-center gap-2">
                                        <span class="text-xl">
                                            🔔
                                        </span>

                                        @if(!$notification->read_at)
                                            <span class="text-xs font-semibold text-red-700">
                                                NOUVEAU
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-gray-800 mt-2">
                                        {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                    </p>

                                    <p class="text-xs text-gray-400 mt-2">
                                        {{ $notification->created_at->format('d/m/Y à H:i') }}
                                    </p>

                                </div>

                                @if(!$notification->read_at)
                                    <a
                                        href="{{ route('notifications.read', $notification->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-red-700 text-white text-sm font-medium rounded-lg hover:bg-red-800 transition"
                                    >
                                        Voir
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">
                                        Lue ✓
                                    </span>
                                @endif

                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>
    </div>
</x-app-layout>
```
