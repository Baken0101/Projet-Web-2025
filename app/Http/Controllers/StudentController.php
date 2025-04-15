<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StudentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Affiche la liste des étudiants autorisés
     */
    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', User::class);

        $students = User::whereHas('schools', function ($query) {
            $query->where('users_schools.role', 'student');
        })->get();

        $cohorts = Cohort::all();

        return view('pages.students.index', compact('students', 'cohorts'));
    }

    /**
     * Affiche le formulaire de création d’un étudiant
     */
    public function showCreateForm(): View|Factory|Application
    {
        $this->authorize('create', User::class);

        $cohorts = Cohort::all();
        return view('pages.students.create', compact('cohorts'));
    }

    /**
     * Crée un nouvel étudiant
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'birth_date'  => 'required|date',
            'cohort_id'   => 'required|exists:cohorts,id',
        ]);

        $user = User::create([
            'last_name'   => $validated['last_name'],
            'first_name'  => $validated['first_name'],
            'email'       => $validated['email'],
            'birth_date'  => $validated['birth_date'],
            'password'    => bcrypt(\Carbon\Carbon::parse($validated['birth_date'])->format('d/m/Y')),
        ]);

        $cohort = Cohort::find($validated['cohort_id']);
        $user->schools()->attach($cohort->school_id, ['role' => 'student', 'cohort_id' => $cohort->id]);

        return redirect()->route('student.index')->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(User $student): View|Factory|Application
    {
        $this->authorize('update', $student);

        $cohorts = Cohort::all();
        return view('pages.students.edit', compact('student', 'cohorts'));
    }

    /**
     * Met à jour les données d’un étudiant
     */
    public function update(Request $request, User $student)
    {
        $this->authorize('update', $student);

        $validated = $request->validate([
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $student->id,
            'birth_date'  => 'required|date',
            'cohort_id'   => 'required|exists:cohorts,id',
        ]);

        $student->update($validated);

        return redirect()->route('student.index')->with('success', 'Étudiant mis à jour.');
    }

    /**
     * Supprime un étudiant
     */
    public function destroy(User $student)
    {
        $this->authorize('delete', $student);

        $student->delete();

        return redirect()->route('student.index')->with('success', 'Étudiant supprimé.');
    }
}
