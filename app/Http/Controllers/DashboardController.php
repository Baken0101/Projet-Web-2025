<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                'studentsCount' => User::whereHas('schools', function ($query) {
                    $query->where('users_schools.role', 'student');
                })->count(),
                'teachersCount' => User::whereHas('schools', function ($query) {
                    $query->where('users_schools.role', 'teacher');
                })->count(),
                'groupsCount' => 0,
            ];
        }

        $view = 'pages.dashboard.dashboard-' . $userRole;

        if (!view()->exists($view)) {
            abort(404, 'Dashboard introuvable pour ce rôle.');
        }

        return view($view, array_merge($data, ['userRole' => $userRole]));
    }
}
