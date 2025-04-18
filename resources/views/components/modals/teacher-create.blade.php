{{-- teacher-create.blade.php --}}
<div class="modal fade" id="teacherCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('teacher.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un enseignant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body space-y-4">
                    <label class="block">
                        <span class="text-gray-700">Prénom</span>
                        <input name="first_name" required class="mt-1 block w-full border-gray-300 rounded px-3 py-2"/>
                    </label>
                    <label class="block">
                        <span class="text-gray-700">Nom</span>
                        <input name="last_name" required class="mt-1 block w-full border-gray-300 rounded px-3 py-2"/>
                    </label>
                    <label class="block">
                        <span class="text-gray-700">Email</span>
                        <input type="email" name="email" required class="mt-1 block w-full border-gray-300 rounded px-3 py-2"/>
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
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
