<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cohort;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userRole = $user->schools->first()?->pivot?->role ?? 'default';

        $data = [];

        if ($userRole === 'admin') {
            $data = [
                'promotionsCount' => Cohort::count(),
                'studentsCount' => User::whereHas('schools', fn($q) => $q->where('role', 'student'))->count(),
                'teachersCount' => User::whereHas('schools', fn($q) => $q->where('role', 'teacher'))->count(),
                'groupsCount' => 0,
            ];

            return view('pages.dashboard.dashboard-admin', array_merge($data, ['userRole' => $userRole]));
        }

        if ($userRole === 'teacher') {
            $promos = Cohort::where('teacher_id', $user->id)->get();

            return view('pages.dashboard.dashboard-teacher', [
                'userRole' => $userRole,
                'promos' => $promos,
            ]);
        }

        if ($userRole === 'student') {
            $cohort = $user->schools()->wherePivot('role', 'student')->first()?->pivot?->cohort;
            $classmates = collect();

            if ($cohort) {
                $classmates = User::whereHas('schools', function ($query) use ($cohort, $user) {
                    $query->where('cohort_id', $cohort->id)->where('role', 'student');
                })->where('id', '!=', $user->id)->get();
            }

            return view('pages.dashboard.dashboard-student', [
                'userRole' => $userRole,
                'cohort' => $cohort,
                'classmates' => $classmates,
            ]);
        }

        abort(403, 'Rôle non reconnu');
    }
}
