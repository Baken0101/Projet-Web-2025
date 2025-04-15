@props(['student', 'cohorts'])

<div x-data="{ open: false }">
    <button type="button" @click="open = true" class="text-blue-600 hover:underline text-sm">
        Modifier
    </button>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">
            <h2 class="text-lg font-semibold mb-4">Modifier l'étudiant</h2>

            <form method="POST" action="{{ route('student.update', $student) }}">
                @csrf
                @method('PUT')

                <x-forms.input name="last_name" label="Nom" :value="$student->last_name" />
                <x-forms.input name="first_name" label="Prénom" :value="$student->first_name" />
                <x-forms.input type="date" name="birth_date" label="Date de naissance"
                               :value="$student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('Y-m-d') : ''" />
                <x-forms.input type="email" name="email" label="Email" :value="$student->email" />

                <x-forms.select-searchable
                    name="cohort_id"
                    label="Formation"
                    :options="$cohorts"
                    :selected="$student->schools->first()?->pivot?->cohort_id"
                    optionValue="id"
                    optionLabel="name"
                />

                <div class="flex justify-end mt-4 gap-2">
                    <button type="button" class="btn btn-secondary" @click="open = false">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
