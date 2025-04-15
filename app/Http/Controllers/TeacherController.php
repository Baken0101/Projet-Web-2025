<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    public function index()
    {
        if (!Gate::allows('viewAny', User::class)) {
            abort(403);
        }

        $teachers = User::whereHas('schools', function ($query) {
            $query->where('role', 'teacher');
        })->get();

        return view('pages.teachers.index', compact('teachers'));
    }
}
