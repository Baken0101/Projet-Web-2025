<?php

namespace App\Providers;

use App\Models\Cohort;
use App\Models\User;
use App\Policies\CohortPolicy;
use App\Policies\StudentPolicy;
use App\Policies\TeacherPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Cohort::class => CohortPolicy::class,
        User::class   => StudentPolicy::class, // Reste la policy principale pour User
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gates spécifiques pour la gestion des enseignants
        Gate::define('view-teachers', [TeacherPolicy::class, 'viewAny']);
        Gate::define('manage-teachers', [TeacherPolicy::class, 'create']);
    }
}
