<!-- Modal for editing a Student -->
<div class="modal fade" id="student-edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="student-edit-form" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="student-edit-id" name="id" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l’étudiant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <x-forms.input id="student-edit-first_name" name="first_name" label="Prénom" required />
                    <x-forms.input id="student-edit-last_name"  name="last_name"  label="Nom"     required />
                    <x-forms.input type="date" id="student-edit-birth_date" name="birth_date" label="Date de naissance" required />
                    <x-forms.input type="email" id="student-edit-email" name="email" label="Email" required />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </form>
    </div>
</div>
