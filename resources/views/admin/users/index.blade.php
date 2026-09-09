<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des utilisateurs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Liste des utilisateurs
                    </h3>

                    {{-- Message de succès --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">

                        <table class="w-full border-collapse">

                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-4 py-3 border">Nom</th>
                                    <th class="px-4 py-3 border">Email</th>
                                    <th class="px-4 py-3 border">Rôle</th>
                                    <th class="px-4 py-3 border">Téléphone</th>
                                    <th class="px-4 py-3 border">Date d'inscription</th>
                                    <th class="px-4 py-3 border">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($users as $user)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-3 border">
                                            {{ $user->name }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ ucfirst($user->role) }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $user->telephone ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $user->created_at?->format('d/m/Y') }}
                                        </td>

                                        <td class="px-4 py-3 border">

                                            {{-- Voir --}}
                                            <a href="{{ route('admin.users.show', $user) }}"
                                               class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                                                Voir
                                            </a>

                                            {{-- Supprimer --}}
                                            <form action="{{ route('admin.users.destroy', $user) }}"
                                                  method="POST"
                                                  class="inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                                        class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">
                                                    Supprimer
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-6 text-center text-gray-500">
                                            Aucun utilisateur trouvé.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>