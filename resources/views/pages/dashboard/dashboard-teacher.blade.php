<x-app-layout>
    <x-slot name="header">
        <h1 class="text-sm font-normal text-gray-700">
            Tableau de bord - Enseignant
        </h1>
    </x-slot>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mes promotions</h3>
            </div>
            <div class="card-body flex flex-col gap-2">
                @forelse ($promos as $promo)
                    <a href="{{ route('cohort.show', $promo) }}" class="text-blue-500 hover:underline">
                        {{ $promo->name }} ({{ \Carbon\Carbon::parse($promo->start_date)->format('Y') }} - {{ \Carbon\Carbon::parse($promo->end_date)->format('Y') }})
                    </a>
                @empty
                    <p class="text-sm text-gray-500">Aucune promotion assignée.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions rapides</h3>
            </div>
            <div class="card-body">
                <p class="text-sm text-gray-600">Accédez aux ressources pédagogiques ou à vos groupes de travail.</p>
            </div>
        </div>
    </div>
</x-app-layout>
