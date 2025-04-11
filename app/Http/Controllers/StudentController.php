<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Affiche la liste des étudiants liés à une école avec le rôle "student"
     */
    public function index(): View|Factory|Application
    {
        // Récupère tous les utilisateurs ayant le rôle "student" via la table pivot users_schools
        $students = User::whereHas('schools', function ($query) {
            $query->where('users_schools.role', 'student');
        })->get();

        // Récupère toutes les promotions pour les afficher dans la vue si besoin
        $cohorts = Cohort::all();

        // Affiche la vue de la liste avec les données
        return view('pages.students.index', compact('students', 'cohorts'));
    }

    /**
     * Affiche le formulaire de création d’un étudiant
     */
    public function showCreateForm(): View|Factory|Application
    {
        // Récupère toutes les promotions pour les afficher dans le formulaire
        $cohorts = Cohort::all();
        return view('pages.students.create', compact('cohorts'));
    }

    /**
     * Enregistre un nouvel étudiant en base de données
     */
    public function create(Request $request)
    {
        // Valide les données envoyées par le formulaire
        $validated = $request->validate([
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'birth_date'  => 'required|date',
            'cohort_id'   => 'required|exists:cohorts,id',
        ], [
            // Messages d'erreurs personnalisés
            'last_name.required'    => 'Le nom est obligatoire.',
            'last_name.max'         => 'Le nom ne doit pas dépasser 255 caractères.',
            'first_name.required'   => 'Le prénom est obligatoire.',
            'first_name.max'        => 'Le prénom ne doit pas dépasser 255 caractères.',
            'email.required'        => 'L\'adresse email est obligatoire.',
            'email.email'           => 'L\'adresse email doit être valide.',
            'email.unique'          => 'Cette adresse email est déjà utilisée.',
            'birth_date.required'   => 'La date de naissance est obligatoire.',
            'birth_date.date'       => 'La date de naissance doit être une date valide.',
            'cohort_id.required'    => 'La formation est obligatoire.',
            'cohort_id.exists'      => 'La formation sélectionnée est invalide.',
        ]);

        // Crée le nouvel utilisateur avec mot de passe basé sur sa date de naissance
        $user = User::create([
            'last_name'   => $validated['last_name'],
            'first_name'  => $validated['first_name'],
            'email'       => $validated['email'],
            'birth_date'  => $validated['birth_date'],
            'password'    => bcrypt(\Carbon\Carbon::parse($validated['birth_date'])->format('d/m/Y')),
        ]);

        // Récupère la formation pour obtenir son school_id
        $cohort = Cohort::find($validated['cohort_id']);

        // Lie l'utilisateur à l'école correspondante avec le rôle "student"
        $user->schools()->attach($cohort->school_id, ['role' => 'student']);

        // Redirige vers la liste avec un message flash
        return redirect()->route('student.index')->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d’un étudiant
     */
    public function edit(User $student): View|Factory|Application
    {
        $cohorts = Cohort::all();
        return view('pages.students.edit', compact('student', 'cohorts'));
    }

    /**
     * Met à jour les informations d’un étudiant
     */
    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $student->id,
            'birth_date'  => 'required|date',
            'cohort_id'   => 'required|exists:cohorts,id',
        ], [
            'last_name.required'    => 'Le nom est obligatoire.',
            'last_name.max'         => 'Le nom ne doit pas dépasser 255 caractères.',
            'first_name.required'   => 'Le prénom est obligatoire.',
            'first_name.max'        => 'Le prénom ne doit pas dépasser 255 caractères.',
            'email.required'        => 'L\'adresse email est obligatoire.',
            'email.email'           => 'L\'adresse email doit être valide.',
            'email.unique'          => 'Cette adresse email est déjà utilisée.',
            'birth_date.required'   => 'La date de naissance est obligatoire.',
            'birth_date.date'       => 'La date de naissance doit être une date valide.',
            'cohort_id.required'    => 'La formation est obligatoire.',
            'cohort_id.exists'      => 'La formation sélectionnée est invalide.',
        ]);

        // Met à jour l'utilisateur avec les nouvelles données
        $student->update($validated);

        return redirect()->route('student.index');
    }

    /**
     * Supprime un étudiant
     */
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('student.index');
    }
}
