<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-700">Promotions</h1>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6 p-6">
        {{-- Tableau des promotions --}}
        <div class="lg:col-span-2">
            <div class="card card-grid">
                <div class="card-header">
                    <h3 class="card-title">Mes promotions</h3>
                </div>
                <div class="card-body overflow-x-auto">
                    <table class="table table-border w-full">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Promotion</th>
                            <th class="px-4 py-2">Année</th>
                            <th class="px-4 py-2"># Étudiants</th>
                            <th class="px-4 py-2">Professeur</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cohorts as $cohort)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    @can('view', $cohort)
                                        <a href="{{ route('cohort.show', $cohort) }}"
                                           class="font-medium text-blue-600 hover:underline">
                                            {{ $cohort->name }}
                                        </a>
                                    @else
                                        {{ $cohort->name }}
                                    @endcan
                                    <div class="text-sm text-gray-500">
                                        {{ $cohort->school->name ?? '—' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($cohort->start_date)->format('Y') }}
                                    –
                                    {{ \Carbon\Carbon::parse($cohort->end_date)->format('Y') }}
                                </td>
                                <td class="px-4 py-2">{{ $cohort->students_count }}</td>
                                <td class="px-4 py-2">
                                    {{ $cohort->teacher?->first_name }}
                                    {{ $cohort->teacher?->last_name }}
                                    @unless($cohort->teacher)
                                        <span class="text-gray-400">Non assigné</span>
                                    @endunless
                                </td>
                                <td class="px-4 py-2 text-center flex justify-center gap-2">
                                    @can('update', $cohort)
                                        <button
                                            data-bs-toggle="modal"
                                            data-bs-target="#promoEditModal-{{ $cohort->id }}"
                                            class="text-blue-600 hover:underline"
                                        >
                                            Modifier
                                        </button>
                                    @endcan
                                    @can('delete', $cohort)
                                        <form method="POST"
                                              action="{{ route('cohort.destroy', $cohort) }}"
                                              onsubmit="return confirm('Supprimer cette promotion ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Supprimer
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">
                                    Aucune promotion trouvée.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Formulaire de création --}}
        @can('create', App\Models\Cohort::class)
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter une promotion</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <form method="POST" action="{{ route('cohort.create') }}">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium">Nom</label>
                                <input type="text" name="name" id="name"
                                       class="w-full px-3 py-2 border rounded"
                                       value="{{ old('name') }}" required>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="w-full px-3 py-2 border rounded">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium">Début</label>
                                <input type="date" name="start_date" id="start_date"
                                       class="w-full px-3 py-2 border rounded"
                                       value="{{ old('start_date') }}" required>
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium">Fin</label>
                                <input type="date" name="end_date" id="end_date"
                                       class="w-full px-3 py-2 border rounded"
                                       value="{{ old('end_date') }}" required>
                            </div>

                            <div>
                                <label for="teacher_id" class="block text-sm font-medium">Professeur</label>
                                <select name="teacher_id" id="teacher_id"
                                        class="w-full px-3 py-2 border rounded">
                                    <option value="">— Aucun —</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}"
                                            {{ old('teacher_id') == $t->id ? 'selected' : '' }}
                                        >
                                            {{ $t->first_name }} {{ $t->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-right">
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Valider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    {{-- Inclusion du modal d’édition --}}
    @foreach($cohorts as $cohort)
        @can('update', $cohort)
            @include('components.modals.promo-edit', ['cohort'=>$cohort, 'teachers'=>$teachers])
        @endcan
    @endforeach

</x-app-layout>
