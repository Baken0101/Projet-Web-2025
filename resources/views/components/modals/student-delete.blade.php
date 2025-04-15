@props(['student'])

<form method="POST" action="{{ route('student.destroy', $student) }}" onsubmit="return confirm('Supprimer cet étudiant ?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 text-sm hover:underline">Supprimer</button>
</form>
