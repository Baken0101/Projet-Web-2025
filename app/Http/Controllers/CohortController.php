<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CohortController extends Controller
{
    use AuthorizesRequests;

    public function index(): View|Factory|Application
    {
        $cohorts = Cohort::with(['school'])->withCount('students')->get();
        $visibleCohorts = $cohorts->filter(fn($cohort) => Gate::allows('view', $cohort));

        return view('pages.cohorts.index', ['cohorts' => $visibleCohorts]);
    }

    public function show(Cohort $cohort): View|Factory|Application
    {
        $this->authorize('view', $cohort);

        $students = $cohort->students;

        $allEligibleStudents = User::whereDoesntHave('schools', function ($query) use ($cohort) {
            $query->where('cohort_id', $cohort->id);
        })->get();

        return view('pages.cohorts.show', compact('cohort', 'students', 'allEligibleStudents'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Cohort::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Cohort::create([
            'school_id' => 1,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->route('cohort.index');
    }

    public function addStudent(Request $request, Cohort $cohort)
    {
        $this->authorize('update', $cohort);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $cohort->school->users()->attach($validated['user_id'], [
            'role' => 'student',
            'cohort_id' => $cohort->id,
        ]);

        return redirect()->route('cohort.show', $cohort)->with('success', 'Étudiant ajouté.');
    }
}
