<?php
// app/Http/Controllers/TeacherController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class TeacherController extends Controller
{
    /**
     * Display a listing of the teachers.
     */
    public function index(): View
    {
        // On ne récupère que les users dont le pivot users_schools.role = 'teacher'
        $teachers = User::whereHas('schools', function($q) {
            $q->where('role', 'teacher');
        })
            ->orderBy('last_name')
            ->get();

        return view('pages.teachers.index', compact('teachers'));
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
        ]);

        // Crée l'utilisateur avec un mot de passe par défaut
        $user = User::create($data + [
                'password' => bcrypt('changeme'),
            ]);

        // Attache à l'école #1 avec pivot.role = 'teacher'
        $user->schools()->attach(1, ['role' => 'teacher']);

        return redirect()->route('teacher.index')->with('success', 'Enseignant créé.');
    }

    /**
     * Update via AJAX.
     */
    public function updateAjax(Request $request, User $teacher)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => "required|email|unique:users,email,{$teacher->id}",
        ]);

        $teacher->update($data);

        return response()->json(['message' => 'Enseignant mis à jour']);
    }

    /**
     * Delete a teacher.
     */
    public function destroy(User $teacher)
    {
        $teacher->delete();
        return redirect()->route('teacher.index')->with('success', 'Enseignant supprimé.');
    }
}
