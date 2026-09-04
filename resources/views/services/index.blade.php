<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes services
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">
                        Mes services
                    </h3>

                    <a href="{{ route('services.create') }}"
                       style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 6px; display: inline-block; font-weight: 600; text-decoration: none;">
                        + Ajouter un service
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse($services as $service)

                    <div class="border rounded-lg p-4 mb-4">

                        <h4 class="text-lg font-bold">
                            {{ $service->nom }}
                        </h4>

                        <p class="text-gray-600 mt-2">
                            {{ $service->description }}
                        </p>

                        @if($service->prix)
                            <p class="mt-2 font-semibold">
                                Prix : {{ $service->prix }} DH
                            </p>
                        @endif

                        <a href="{{ route('services.edit', $service) }}"
                           style="background-color: #4f46e5; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 10px;">
                            Modifier
                        </a>
<form method="POST"
      action="{{ route('services.destroy', $service) }}"
      style="display: inline-block; margin-top: 10px;">
    @csrf
    @method('DELETE')

    <button
        type="submit"
        onclick="return confirm('Voulez-vous vraiment supprimer ce service ?')"
        style="background-color: #dc2626; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer;"
    >
        Supprimer
    </button>
</form>
                    </div>

                @empty

                    <p class="text-gray-500">
                        Aucun service ajouté.
                    </p>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>