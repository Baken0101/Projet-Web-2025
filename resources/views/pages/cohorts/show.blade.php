<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">{{ $cohort->name }}</span>
            <span class="ml-2 text-sm text-gray-500">(Responsable : {{ $cohort->teacher?->full_name ?? 'non assigné' }})</span>
        </h1>
    </x-slot>


    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        {{-- Liste des étudiants --}}
        <div class="lg:col-span-2">
            <div class="card card-grid h-full min-w-full">
                <div class="card-header">
                    @if (session('success'))
                        <x-auth-session-status :status="session('success')" class="mb-4" />
                    @endif
                    <h3 class="card-title">Étudiants</h3>
                </div>
                <div class="card-body">
                    <div class="scrollable-x-auto">
                        <table class="table table-border">
                            <thead>
                            <tr>
                                <th class="min-w-[135px]">Nom</th>
                                <th class="min-w-[135px]">Prénom</th>
                                <th class="min-w-[135px]">Date de naissance</th>
                                <th class="w-[50px]"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->last_name }}</td>
                                    <td>{{ $student->first_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        {{-- On pourrait ajouter des actions ici (ex: suppression, détails) --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-sm text-gray-500">
                                        Aucun étudiant dans cette promotion.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire d’ajout d’un étudiant à la promo (visible seulement si autorisé) --}}
        @can('update', $cohort)
            <div class="lg:col-span-1">
                <div class="card h-full">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter un étudiant</h3>
                    </div>
                    <div class="card-body flex flex-col gap-5">
                        <form method="POST" action="{{ route('cohort.addStudent', $cohort) }}">
                            @csrf

                            <x-forms.dropdown name="user_id" label="Étudiant">
                                @foreach($allEligibleStudents as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->full_name }}
                                    </option>
                                @endforeach
                            </x-forms.dropdown>

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
