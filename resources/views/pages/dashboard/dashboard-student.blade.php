<x-app-layout>
    <x-slot name="header">
        <h1 class="text-sm font-normal text-gray-700">
            Tableau de bord - Étudiant
        </h1>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ma formation</h3>
        </div>
        <div class="card-body">
            @php
                $pivot = auth()->user()->schools->first()?->pivot;
                $cohort = $pivot?->cohort_id ? \App\Models\Cohort::find($pivot->cohort_id) : null;
            @endphp

            @if($cohort)
                <p>Vous êtes inscrit à la promotion : <strong>{{ $cohort->name }}</strong></p>
                <a href="{{ route('cohort.show', $cohort->id) }}" class="text-blue-500 hover:underline">
                    Voir la promotion
                </a>
            @else
                <p class="text-sm text-gray-500">Aucune promotion associée.</p>
            @endif
        </div>
    </div>
</x-app-layout>
