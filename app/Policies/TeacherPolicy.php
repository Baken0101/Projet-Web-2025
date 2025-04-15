<?php

namespace App\Policies;

use App\Models\User;

class TeacherPolicy
{
    /**
     * Autorise les admins à voir la page enseignants.
     */
    public function viewAny(User $user): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }

    /**
     * Autorise les admins à créer des enseignants.
     */
    public function create(User $user): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }

    /**
     * Autorise les admins à mettre à jour un enseignant.
     */
    public function update(User $user, User $teacher): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }

    /**
     * Autorise les admins à supprimer un enseignant.
     */
    public function delete(User $user, User $teacher): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }
}
