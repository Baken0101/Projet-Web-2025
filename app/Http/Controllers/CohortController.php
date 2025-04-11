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
     * Affiche toutes les promotions (cohorts).
     *
     * @return Factory|View|Application|object
     */
    public function index()
    {
        // Affiche la vue qui liste les promotions
        return view('pages.cohorts.index');
    }

    /**
     * Traite la création d'une nouvelle promotion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        // Valide les données envoyées depuis le formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',               // Nom obligatoire, max 255 caractères
            'description' => 'required|string|max:1000',       // Description obligatoire, max 1000
            'start_date' => 'required|date',                   // Date de début valide et obligatoire
            'end_date' => 'required|date|after_or_equal:start_date', // Date de fin obligatoire, doit être >= start_date
        ], [
            // Messages personnalisés en cas d’erreur
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
        ]);

        // Crée la promotion avec les données validées
        Cohort::create([
            'school_id' => 1,                            // ID de l’école associé en dur (à rendre dynamique plus tard)
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        // Redirige vers la page des promotions
        return redirect()->route('cohort.index');
    }

    /**
     * Affiche une promotion spécifique.
     *
     * @param Cohort $cohort
     * @return Application|Factory|object|View
     */
    public function show(Cohort $cohort)
    {
        // Retourne la vue de détails avec la promotion passée en paramètre
        return view('pages.cohorts.show', [
            'cohort' => $cohort
        ]);
    }
}
