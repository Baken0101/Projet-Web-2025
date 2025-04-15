<?php

namespace App\Policies;

use App\Models\Cohort;
use App\Models\User;

class CohortPolicy
{
    public function viewAny(User $user): bool
    {
        $role = $user->schools->first()?->pivot?->role;
        return in_array($role, ['admin', 'teacher', 'student']);
    }

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

    public function create(User $user): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }

    public function delete(User $user, Cohort $cohort): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }

}
