{{-- resources/views/modals/promo-create.blade.php --}}
<div class="modal fade" id="promoCreateModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('cohort.create') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body space-y-3">
                    {{-- Name --}}
                    <x-forms.input name="name" label="Nom" required />
                    {{-- Description --}}
                    <x-forms.textarea name="description" label="Description" />
                    {{-- Start Date --}}
                    <x-forms.input type="date" name="start_date" label="Date de début" id="promo-start" required />
                    {{-- End Date --}}
                    <x-forms.input type="date" name="end_date"   label="Date de fin"   id="promo-end"   required />
                    {{-- Teacher Selection --}}
                    <x-forms.select name="teacher_id" label="Professeur responsable" required>
                        <option value="">Sélectionner…</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->full_name }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div class="modal-footer">
                    <x-ui.button color="default" size="sm" data-bs-dismiss="modal">Annuler</x-ui.button>
                    <x-ui.button color="success" size="sm" type="submit">Enregistrer</x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const start = document.getElementById('promo-start');
        const end   = document.getElementById('promo-end');
        // Ensure end date is never before start date
        start.addEventListener('change', () => {
            end.min = start.value;
            if (end.value < start.value) end.value = start.value;
        });
    });
</script>
