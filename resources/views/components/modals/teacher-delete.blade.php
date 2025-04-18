{{-- teacher-delete.blade.php --}}
@props(['teacher'])

<div class="modal fade" id="teacherDeleteModal-{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-red-600">Supprimer ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Voulez‑vous vraiment supprimer
                <strong>{{ $teacher->first_name }} {{ $teacher->last_name }}</strong> ?
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="bg-gray-600 hover:bg-gray-700 text-white rounded px-3 py-1"
                    data-bs-dismiss="modal"
                >
                    Annuler
                </button>
                <form method="POST" action="{{ route('teacher.destroy', $teacher) }}">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white rounded px-3 py-1"
                    >
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
