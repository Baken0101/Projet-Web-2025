{{-- resources/views/pages/teachers/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-700">Gestion des enseignants</h1>
    </x-slot>

    <div class="grid lg:grid-cols-3 gap-5 items-stretch">
        {{-- —————————— Teacher list —————————— --}}
        <div class="lg:col-span-2">
            <div class="card h-full">
                <div class="card-header flex justify-between items-center">
                    <h3 class="card-title">Liste des enseignants</h3>
                    <div class="flex items-center space-x-2">
                        <input
                            id="teacher-search"
                            type="text"
                            placeholder="Rechercher…"
                            class="px-3 py-2 border rounded focus:outline-none focus:ring"
                        />
                        <button
                            type="button"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#teacherCreateModal"
                        >+ Ajouter</button>
                    </div>
                </div>

                <div class="card-body overflow-x-auto">
                    <table id="teacher-table" class="min-w-full border">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nom</th>
                            <th class="px-4 py-2">Prénom</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($teachers as $t)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $t->last_name }}</td>
                                <td class="px-4 py-2">{{ $t->first_name }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex justify-center space-x-3">
                                        <button
                                            type="button"
                                            class="text-blue-600 hover:text-blue-800"
                                            data-bs-toggle="modal"
                                            data-bs-target="#teacherEditModal-{{ $t->id }}"
                                        >Modifier</button>
                                        <button
                                            type="button"
                                            class="text-red-600 hover:text-red-800"
                                            data-bs-toggle="modal"
                                            data-bs-target="#teacherDeleteModal-{{ $t->id }}"
                                        >Supprimer</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                                    Aucun enseignant trouvé.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- include each teacher’s modals _after_ the table --}}
            @foreach($teachers as $t)
                @include('components.modals.teacher-edit',   ['teacher' => $t])
                @include('components.modals.teacher-delete', ['teacher' => $t])
            @endforeach
        </div>

        {{-- —————————— Add‑teacher form —————————— --}}
        <div class="lg:col-span-1">
            <div class="card h-full">
                <div class="card-header">
                    <h3 class="card-title">Ajouter un enseignant</h3>
                </div>
                <div class="card-body flex flex-col gap-5">
                    <form method="POST" action="{{ route('teacher.store') }}">
                        @csrf

                        <label class="block text-sm font-medium">Prénom</label>
                        <input
                            type="text"
                            name="first_name"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring"
                            required
                        />

                        <label class="block text-sm font-medium mt-4">Nom</label>
                        <input
                            type="text"
                            name="last_name"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring"
                            required
                        />

                        <label class="block text-sm font-medium mt-4">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring"
                            required
                        />

                        <div class="text-right mt-6">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                            >Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Create‑teacher modal (no per‑teacher data) --}}
    @include('components.modals.teacher-create')

    {{-- Live‑search JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('teacher-search');
            const rows  = Array.from(document.querySelectorAll('#teacher-table tbody tr'));

            input.addEventListener('input', () => {
                const term = input.value.toLowerCase();
                rows.forEach(r => {
                    r.style.display = r.textContent.toLowerCase().includes(term)
                        ? ''
                        : 'none';
                });
            });
        });
    </script>
</x-app-layout>
