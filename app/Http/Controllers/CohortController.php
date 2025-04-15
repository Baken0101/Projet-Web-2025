<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class CohortController extends Controller
{
    public function index(): View|Factory|Application
    {
        $cohorts = Cohort::with('school', 'teacher')->withCount('students')->get();
        $visibleCohorts = $cohorts->filter(fn($cohort) => Gate::allows('view', $cohort));
        $teachers = User::whereHas('schools', fn($q) => $q->where('role', 'teacher'))->get();

        return view('pages.cohorts.index', [
            'cohorts' => $visibleCohorts,
            'teachers' => $teachers,
        ]);
    }

    public function show(Cohort $cohort): View|Factory|Application
    {
        $this->authorize('view', $cohort);

        $students = $cohort->students;
        $allEligibleStudents = User::whereDoesntHave('schools', fn($q) =>
        $q->where('cohort_id', $cohort->id)
        )->get();

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

        return redirect()->route('cohort.index')->with('success', 'Promotion créée.');
    }

    public function destroy(Cohort $cohort)
    {
        $this->authorize('delete', $cohort);
        $cohort->delete();
        return redirect()->route('cohort.index')->with('success', 'Promotion supprimée.');
    }

    public function updateAjax(Request $request, Cohort $cohort)
    {
        $this->authorize('update', $cohort);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $cohort->update($validated);

        return response()->json([
            'message' => 'Promotion mise à jour avec succès.',
            'cohort' => $cohort
        ]);
    }

    public function teacherCohorts(): View
    {
        $user = auth()->user();

        if ($user->schools->first()?->pivot?->role !== 'teacher') {
            abort(403);
        }

        $cohorts = Cohort::where('teacher_id', $user->id)->withCount('students')->get();

        return view('pages.teachers.cohorts', compact('cohorts'));
    }
}
