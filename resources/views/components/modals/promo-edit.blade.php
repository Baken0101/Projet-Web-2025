@props(['cohort','teachers'])

<!-- Modal EDIT Promotion -->
<div id="promoEditModal-{{ $cohort->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="promo-edit-form-{{ $cohort->id }}"
              action="{{ route('cohort.update.ajax', $cohort) }}"
              method="POST"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Modifier la promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body space-y-4">
                <div>
                    <label for="name-{{ $cohort->id }}" class="block text-sm font-medium">Nom</label>
                    <input type="text"
                           id="name-{{ $cohort->id }}"
                           name="name"
                           value="{{ old('name',$cohort->name) }}"
                           class="w-full px-3 py-2 border rounded"
                           required>
                </div>

                <div>
                    <label for="description-{{ $cohort->id }}" class="block text-sm font-medium">Description</label>
                    <textarea id="description-{{ $cohort->id }}"
                              name="description"
                              rows="3"
                              class="w-full px-3 py-2 border rounded">{{ old('description',$cohort->description) }}</textarea>
                </div>

                <div>
                    <label for="start_date-{{ $cohort->id }}" class="block text-sm font-medium">Début</label>
                    <input type="date"
                           id="start_date-{{ $cohort->id }}"
                           name="start_date"
                           value="{{ old('start_date',$cohort->start_date) }}"
                           class="w-full px-3 py-2 border rounded"
                           required>
                </div>

                <div>
                    <label for="end_date-{{ $cohort->id }}" class="block text-sm font-medium">Fin</label>
                    <input type="date"
                           id="end_date-{{ $cohort->id }}"
                           name="end_date"
                           value="{{ old('end_date',$cohort->end_date) }}"
                           class="w-full px-3 py-2 border rounded"
                           required>
                </div>

                <div>
                    <label for="teacher_id-{{ $cohort->id }}" class="block text-sm font-medium">Professeur</label>
                    <select id="teacher_id-{{ $cohort->id }}"
                            name="teacher_id"
                            class="w-full px-3 py-2 border rounded">
                        <option value="">— Aucun —</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}"
                                {{ old('teacher_id',$cohort->teacher_id)==$t->id ? 'selected':'' }}>
                                {{ $t->first_name }} {{ $t->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Annuler
                </button>
                <button type="submit"
                        class="btn btn-primary">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
