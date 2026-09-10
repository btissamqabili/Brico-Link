<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-4">

            <a
                href="{{ route('conversations.index') }}"
                style="color: #6b7280;"
            >
                ←
            </a>

            @php
                $contact = auth()->user()->role === 'client'
                    ? $conversation->prestataire
                    : $conversation->client;
            @endphp

            <div>
                <h2
                    style="font-size: 20px; font-weight: 600; color: #1f2937;"
                >
                    💬 {{ $contact->name }}
                </h2>

                <p style="font-size: 14px; color: #6b7280;">
                    {{ $contact->role === 'prestataire' ? 'Prestataire' : 'Client' }}
                </p>
            </div>

        </div>
    </x-slot>


    <div style="padding-top: 32px; padding-bottom: 32px;">

        <div
            style="
                max-width: 896px;
                margin: 0 auto;
                padding-left: 24px;
                padding-right: 24px;
            "
        >

            <div
                style="
                    background: white;
                    border-radius: 16px;
                    border: 1px solid #e5e7eb;
                    overflow: hidden;
                "
            >

                {{-- Zone des messages --}}
                <div
                    style="
                        padding: 24px;
                        min-height: 400px;
                        max-height: 550px;
                        overflow-y: auto;
                    "
                >

                    @forelse($conversation->messages as $message)

                        @if($message->sender_id === auth()->id())

                            {{-- Message envoyé par moi --}}
                            <div
                                style="
                                    display: flex;
                                    justify-content: flex-end;
                                    margin-bottom: 16px;
                                "
                            >

                                <div style="max-width: 75%;">

                                    <div
                                        style="
                                            background-color: #7F2020 !important;
                                            color: #ffffff !important;
                                            padding: 12px 16px;
                                            border-radius: 16px;
                                            border-bottom-right-radius: 4px;
                                            display: block;
                                            font-size: 15px;
                                            line-height: 1.5;
                                        "
                                    >
                                        <span style="color: #ffffff !important;">
                                            {{ $message->contenu }}
                                        </span>
                                    </div>

                                    <p
                                        style="
                                            font-size: 12px;
                                            color: #9ca3af;
                                            text-align: right;
                                            margin-top: 4px;
                                        "
                                    >
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </p>

                                </div>

                            </div>

                        @else

                            {{-- Message reçu --}}
                            <div
                                style="
                                    display: flex;
                                    justify-content: flex-start;
                                    margin-bottom: 16px;
                                "
                            >

                                <div style="max-width: 75%;">

                                    <div
                                        style="
                                            background-color: #f3f4f6 !important;
                                            color: #1f2937 !important;
                                            padding: 12px 16px;
                                            border-radius: 16px;
                                            border-bottom-left-radius: 4px;
                                            display: block;
                                            font-size: 15px;
                                            line-height: 1.5;
                                        "
                                    >
                                        <span style="color: #1f2937 !important;">
                                            {{ $message->contenu }}
                                        </span>
                                    </div>

                                    <p
                                        style="
                                            font-size: 12px;
                                            color: #9ca3af;
                                            margin-top: 4px;
                                        "
                                    >
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </p>

                                </div>

                            </div>

                        @endif

                    @empty

                        <div
                            style="
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                min-height: 350px;
                            "
                        >
                            <div style="text-align: center;">

                                <div style="font-size: 40px; margin-bottom: 12px;">
                                    💬
                                </div>

                                <p style="color: #6b7280;">
                                    Aucun message pour le moment.
                                </p>

                                <p
                                    style="
                                        font-size: 14px;
                                        color: #9ca3af;
                                        margin-top: 4px;
                                    "
                                >
                                    Commencez la conversation.
                                </p>

                            </div>
                        </div>

                    @endforelse

                </div>


                {{-- Formulaire --}}
                <div
                    style="
                        border-top: 1px solid #e5e7eb;
                        padding: 16px;
                    "
                >

                    <form
                        action="{{ route('messages.store', $conversation) }}"
                        method="POST"
                        style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        "
                    >

                        @csrf

                        <input
                            type="text"
                            name="contenu"
                            required
                            maxlength="2000"
                            placeholder="Écrire un message..."
                            style="
                                flex: 1;
                                border: 1px solid #d1d5db;
                                border-radius: 10px;
                                padding: 12px;
                                color: #1f2937;
                                background-color: #ffffff;
                            "
                        >

                        <button
                            type="submit"
                            style="
                                background-color: #7F2020;
                                color: #ffffff;
                                padding: 12px 20px;
                                border-radius: 10px;
                                font-weight: 500;
                                border: none;
                                cursor: pointer;
                            "
                        >
                            Envoyer
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>