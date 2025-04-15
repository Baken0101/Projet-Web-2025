@props(['cohort'])

<div x-data="{ open: false }">
    <button type="button" @click="open = true" class="text-blue-600 hover:underline text-sm">Modifier</button>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">
            <h2 class="text-lg font-semibold mb-4">Modifier la promotion</h2>

            <form @submit.prevent="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{ $cohort->id }}">

                <x-forms.input name="name" :value="$cohort->name" label="Nom" />
                <x-forms.input name="description" :value="$cohort->description" label="Description" />
                <x-forms.input type="date" name="start_date" :value="\Carbon\Carbon::parse($cohort->start_date)->format('Y-m-d')" label="Début" />
                <x-forms.input type="date" name="end_date" :value="\Carbon\Carbon::parse($cohort->end_date)->format('Y-m-d')" label="Fin" />

                {{-- Affectation professeur --}}
                <x-forms.select-searchable
                    name="teacher_id"
                    label="Professeur"
                    :options="$teachers"
                    optionValue="id"
                    optionLabel="full_name"
                    :selected="$cohort->teacher_id"
                />

                <div class="flex justify-end mt-4 gap-2">
                    <button type="button" class="btn btn-secondary" @click="open = false">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function submitForm(e) {
            const form = e.target.closest('form');
            const cohortId = form.querySelector('input[name="id"]').value;
            const formData = new FormData(form);

            fetch(`/cohort/${cohortId}/edit`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || "Mise à jour réussie.");
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                    alert("Une erreur s’est produite.");
                });
        }
    </script>
</div>
