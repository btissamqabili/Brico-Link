<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Mes notifications
                </h3>

                @forelse($notifications as $notification)

                    <div
                        class="border rounded-lg p-4 mb-4
                        {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}"
                    >

                        <div class="flex justify-between items-center">

                            <div>
                                <p class="font-semibold">
                                    {{ $notification->data['message'] }}
                                </p>

                                @if(isset($notification->data['prix_propose']))
                                    <p class="text-gray-600 mt-2">
                                        Prix proposé :
                                        {{ $notification->data['prix_propose'] }} DH
                                    </p>
                                @endif

                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $notification->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            @if(!$notification->read_at)

                                <a
                                    href="{{ route('notifications.read', $notification->id) }}"
                                    style="
                                        background-color:#4f46e5;
                                        color:white;
                                        padding:8px 16px;
                                        border-radius:6px;
                                        font-weight:600;
                                        text-decoration:none;
                                        display:inline-block;
                                    "
                                >
                                    Voir l'offre
                                </a>

                            @else

                                <span class="text-sm text-gray-500">
                                    Lu
                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <p class="text-gray-500">
                        Aucune notification pour le moment.
                    </p>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>