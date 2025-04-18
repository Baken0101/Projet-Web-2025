<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a paginated listing of students.
     */
    public function index()
    {
        // Retrieve students with pagination
        $students = User::orderBy('last_name')
            ->paginate(5);  // paginate 5 per page

        // Needed for edit-modal or select-searchable
        $cohorts = Cohort::orderBy('name')->get();

        // Note: view path corrected to pages.students.index
        return view('pages.students.index', compact('students', 'cohorts'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function showCreateForm()
    {
        $cohorts = Cohort::orderBy('name')->get();

        // Note: view path corrected to pages.students.create (à créer)
        return view('pages.students.create', compact('cohorts'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'birth_date'  => 'required|date',
            'email'       => 'required|email|unique:students,email',
            'cohort_id'   => 'required|exists:cohorts,id',
        ]);

        User::create($data);

        return redirect()
            ->route('student.index')
            ->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $cohorts = Cohort::orderBy('name')->get();
        return view('pages.students.edit', compact('student', 'cohorts'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'birth_date'  => 'required|date',
            'email'       => "required|email|unique:students,email,{$student->id}",
            'cohort_id'   => 'required|exists:cohorts,id',
        ]);

        $student->update($data);

        return redirect()
            ->route('student.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', 'Étudiant supprimé.');
    }
}
