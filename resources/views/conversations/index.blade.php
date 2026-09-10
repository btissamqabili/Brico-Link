<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    💬 Mes conversations
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Retrouvez vos échanges avec les clients et prestataires.
                </p>
            </div>

            <span class="text-sm text-gray-500">
                {{ $conversations->count() }} conversation(s)
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if($conversations->isEmpty())

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                    <div class="text-5xl mb-4">
                        💬
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Aucune conversation
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Vous n'avez pas encore de conversation.
                    </p>
                </div>

            @else

                <div class="space-y-4">

                    @foreach($conversations as $conversation)

                        @php
                            $contact = auth()->user()->role === 'client'
                                ? $conversation->prestataire
                                : $conversation->client;

                            $unreadCount = $conversation->unreadMessagesCount();
                        @endphp

                        <a
                            href="{{ route('conversations.show', $conversation) }}"
                            class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-red-200 transition"
                        >
                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-bold text-lg">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">

                                            <h3 class="font-semibold text-gray-800">
                                                {{ $contact->name }}
                                            </h3>

                                            @if($unreadCount > 0)
                                                <span
                                                    class="inline-flex items-center justify-center min-w-6 h-6 px-2 rounded-full text-xs font-bold text-white"
                                                    style="background-color: #7F2020;"
                                                >
                                                    {{ $unreadCount }}
                                                </span>
                                            @endif

                                        </div>

                                        <p class="text-sm text-gray-500">
                                            {{ $contact->role === 'prestataire' ? 'Prestataire' : 'Client' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="text-gray-400 text-xl">
                                    →
                                </div>

                            </div>
                        </a>

                    @endforeach

                </div>

            @endif

        </div>
    </div>
</x-app-layout>

