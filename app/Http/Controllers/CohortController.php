<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    /**
     * Display all available cohorts
     * @return Factory|View|Application|object
     */
    public function index() {
        return view('pages.cohorts.index');
    }

    public function create(request $request)
    {
        $school_id = 1;
        $name = $request->name;
        $description = $request->description;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if($name == null || $description == null || $start_date == null || $end_date == null) {
            return redirect()->route('cohort.index');
        }
        else{
            $sendcohort = new Cohort();
            $sendcohort -> school_id = $school_id;
            $sendcohort -> name = $name;
            $sendcohort -> description = $description;
            $sendcohort -> start_date = $start_date;
            $sendcohort -> end_date = $end_date;
            $sendcohort -> save();
            return redirect()->route('cohort.index');

        }

    }

    /**
     * Display a specific cohort
     * @param Cohort $cohort
     * @return Application|Factory|object|View
     */
    public function show(Cohort $cohort) {

        return view('pages.cohorts.show', [
            'cohort' => $cohort
        ]);
    }
}
