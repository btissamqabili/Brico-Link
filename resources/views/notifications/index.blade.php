<x-app-layout>

    <div class="max-w-4xl mx-auto py-8">

        <h1 class="text-2xl font-bold mb-6">
            🔔 Mes notifications
        </h1>

        @if($notifications->isEmpty())

            <div class="bg-white p-6 rounded-lg shadow text-gray-500">
                Aucune notification pour le moment.
            </div>

        @else

            <div class="space-y-4">

                @foreach($notifications as $notification)

                    <a
                        href="{{ route('notifications.read', $notification->id) }}"
                        class="block p-4 rounded-lg shadow
                        {{ $notification->read_at ? 'bg-white' : 'bg-blue-50 border border-blue-200' }}
                        hover:bg-gray-100"
                    >

                        <div class="flex justify-between items-start">

                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $notification->data['message'] }}
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Prix proposé :
                                    {{ $notification->data['prix_propose'] }} DH
                                </p>

                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $notification->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>

                            @if(!$notification->read_at)
                                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                    Nouvelle
                                </span>
                            @endif

                        </div>

                    </a>

                @endforeach

            </div>

        @endif

    </div>

</x-app-layout>