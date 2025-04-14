<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">{{ __('Promotions') }}</span>
        </h1>
    </x-slot>

    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">Mes promotions</h3>
                    </div>
                    <div class="card-body">
                        <div class="scrollable-x-auto">
                            <table class="table table-border">
                                <thead>
                                <tr>
                                    <th class="min-w-[280px]">Promotion</th>
                                    <th class="min-w-[135px]">Année</th>
                                    <th class="min-w-[135px]">Étudiants</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($cohorts as $cohort)
                                    <tr>
                                        <td>
                                            <div class="flex flex-col gap-2">
                                                @can('view', $cohort)
                                                    <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                       href="{{ route('cohort.show', $cohort->id) }}">
                                                        {{ $cohort->name }}
                                                    </a>
                                                @else
                                                    <span class="text-sm text-gray-600">{{ $cohort->name }}</span>
                                                @endcan
                                                <span class="text-2sm text-gray-700 font-normal leading-3">
                                                        {{ $cohort->school->name ?? 'École inconnue' }}
                                                    </span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($cohort->start_date)->format('Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($cohort->end_date)->format('Y') }}
                                        </td>
                                        <td>{{ $cohort->students_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Aucune promotion trouvée.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire visible seulement si l'utilisateur peut créer --}}
        @can('create', App\Models\Cohort::class)
            <div class="lg:col-span-1">
                <div class="card h-full">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter une promotion</h3>
                    </div>
                    <div class="card-body flex flex-col gap-5">
                        <form method="POST" action="{{ route('cohort.create') }}">
                            @csrf
                            <x-forms.input name="name" :label="__('Nom')" />
                            <x-forms.input name="description" :label="__('Description')" />
                            <x-forms.input type="date" name="start_date" :label="__('Début de l\'année')" />
                            <x-forms.input type="date" name="end_date" :label="__('Fin de l\'année')" />
                            <x-forms.primary-button type="submit">
                                {{ __('Valider') }}
                            </x-forms.primary-button>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</x-app-layout>
