{{-- teacher-edit.blade.php --}}
@props(['teacher'])

<div class="modal fade" id="teacherEditModal-{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form
            id="teacher-edit-form-{{ $teacher->id }}"
            action="{{ route('teacher.update.ajax', $teacher) }}"
            method="POST"
            class="modal-content"
        >
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">
                    Modifier {{ $teacher->first_name }} {{ $teacher->last_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body space-y-4">
                <label class="block">
                    <span class="text-gray-700">Prénom</span>
                    <input
                        id="teacher-edit-first-{{ $teacher->id }}"
                        name="first_name"
                        value="{{ $teacher->first_name }}"
                        required
                        class="mt-1 block w-full border-gray-300 rounded px-3 py-2"
                    />
                </label>

                <label class="block">
                    <span class="text-gray-700">Nom</span>
                    <input
                        id="teacher-edit-last-{{ $teacher->id }}"
                        name="last_name"
                        value="{{ $teacher->last_name }}"
                        required
                        class="mt-1 block w-full border-gray-300 rounded px-3 py-2"
                    />
                </label>

                <label class="block">
                    <span class="text-gray-700">Email</span>
                    <input
                        id="teacher-edit-email-{{ $teacher->id }}"
                        name="email"
                        value="{{ $teacher->email }}"
                        required
                        class="mt-1 block w-full border-gray-300 rounded px-3 py-2"
                    />
                </label>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="bg-gray-600 hover:bg-gray-700 text-white rounded px-3 py-1"
                    data-bs-dismiss="modal"
                >
                    Annuler
                </button>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2"
                >
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
