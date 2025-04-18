<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CohortController extends Controller
{
    /**
     * Affiche la liste des promotions (avec filtre d’autorisation).
     */
    public function index(): View
    {
        // Charge promotions + count des students via la relation pivot
        $cohorts = Cohort::with(['school','teacher'])
            ->withCount('students')
            ->get()
            ->filter(fn($c) => Gate::allows('view',$c));

        // Pour le select de création / édition
        $teachers = User::whereHas('schools', fn($q) => $q->where('role','teacher'))
            ->orderBy('last_name')
            ->get();

        return view('pages.cohorts.index', compact('cohorts','teachers'));
    }

    /**
     * Affiche une promotion et ses étudiants.
     */
    public function show(Cohort $cohort): View
    {
        $this->authorize('view',$cohort);

        $students = $cohort->students()->orderBy('last_name')->get();

        // Students non encore rattachés à cette promotion
        $allEligibleStudents = User::whereDoesntHave('schools', fn($q) =>
        $q->where('cohort_id',$cohort->id)
        )->orderBy('last_name')->get();

        return view('pages.cohorts.show', compact('cohort','students','allEligibleStudents'));
    }

    /**
     * Stocke une nouvelle promotion.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Cohort::class);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'teacher_id'  => 'nullable|exists:users,id',
        ]);

        // Id de l’école « par défaut » (à adapter si vous avez plusieurs schools)
        $data['school_id'] = 1;

        Cohort::create($data);

        return redirect()->route('cohort.index')
            ->with('success','Promotion créée.');
    }

    /**
     * Met à jour une promotion (via AJAX).
     */
    public function updateAjax(Request $request, Cohort $cohort)
    {
        $this->authorize('update',$cohort);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'teacher_id'  => 'nullable|exists:users,id',
        ]);

        $cohort->update($data);

        return response()->json([
            'message' => 'Promotion mise à jour.',
            'cohort'  => $cohort,
        ]);
    }

    /**
     * Supprime une promotion.
     */
    public function destroy(Cohort $cohort)
    {
        $this->authorize('delete',$cohort);
        $cohort->delete();

        return redirect()->route('cohort.index')
            ->with('success','Promotion supprimée.');
    }
}
