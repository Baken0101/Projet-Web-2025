<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">{{ __('Étudiants') }}</span>
        </h1>
    </x-slot>

    @if (session('success'))
        <x-auth-session-status :status="session('success')" class="mb-4" />
    @endif

    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        {{-- Liste des étudiants --}}
        <div class="lg:col-span-2">
            <div class="card card-grid h-full min-w-full">
                <div class="card-header">
                    <h3 class="card-title">Liste des étudiants</h3>
                    <div class="input input-sm max-w-48">
                        <i class="ki-filled ki-magnifier"></i>
                        <input placeholder="Rechercher un étudiant" type="text" />
                    </div>
                </div>
                <div class="card-body">
                    <div data-datatable="true" data-datatable-page-size="5">
                        <div class="scrollable-x-auto">
                            <table class="table table-border" data-datatable-table="true">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>{{ $student->last_name }}</td>
                                        <td>{{ $student->first_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}</td>
                                        <td class="text-center flex items-center justify-center gap-2">
                                            @can('update', $student)
                                                {{-- On passe $cohorts à la modale --}}
                                                <x-modals.student-edit :student="$student" :cohorts="$cohorts" />
                                            @endcan

                                            @can('delete', $student)
                                                <form method="POST" action="{{ route('student.destroy', $student) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 text-sm hover:underline">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500">Aucun étudiant trouvé.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                            <div class="flex items-center gap-2 order-2 md:order-1">
                                Show
                                <select class="select select-sm w-16" data-datatable-size="true" name="perpage"></select>
                                per page
                            </div>
                            <div class="flex items-center gap-4 order-1 md:order-2">
                                <span data-datatable-info="true"></span>
                                <div class="pagination" data-datatable-pagination="true"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire d’ajout d’un étudiant --}}
        @can('create', App\Models\User::class)
            <div class="lg:col-span-1">
                <div class="card h-full">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter un étudiant</h3>
                    </div>
                    <div class="card-body flex flex-col gap-5">
                        <form method="POST" action="{{ route('student.create') }}">
                            @csrf
                            <x-forms.input name="last_name" :label="__('Nom')" />
                            <x-forms.input name="first_name" :label="__('Prénom')" />
                            <x-forms.input type="date" name="birth_date" :label="__('Date de naissance')" />
                            <x-forms.input type="email" name="email" :label="__('Email')" />
                            <x-forms.select-searchable
                                name="cohort_id"
                                label="Formation"
                                :options="$cohorts"
                                optionValue="id"
                                optionLabel="name"
                            />
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
