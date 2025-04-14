<?php

namespace App\Policies;

use App\Models\Cohort;
use App\Models\User;

class CohortPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des promotions
     */
    public function viewAny(User $user): bool
    {
        $role = $user->schools->first()?->pivot?->role;

        // Autorise l'accès aux rôles admin, teacher et student
        return in_array($role, ['admin', 'teacher', 'student']);
    }

    /**
     * Détermine si l'utilisateur peut voir une promotion spécifique
     */
    public function view(User $user, Cohort $cohort): bool
    {
        $role = $user->schools->first()?->pivot?->role;

        if (in_array($role, ['admin', 'teacher'])) {
            return true;
        }

        return $user->schools()
            ->wherePivot('cohort_id', $cohort->id)
            ->wherePivot('role', 'student')
            ->exists();
    }

    public function update(User $user, Cohort $cohort): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }


}
