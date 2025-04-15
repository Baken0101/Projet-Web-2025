<?php

namespace App\Policies;

use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->schools->first()?->pivot?->role, ['admin', 'teacher']);
    }

    public function view(User $user, User $student): bool
    {
        return $user->id === $student->id || in_array($user->schools->first()?->pivot?->role, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }

    public function update(User $user, User $student): bool
    {
        return in_array($user->schools->first()?->pivot?->role, ['admin', 'teacher']);
    }

    public function delete(User $user, User $student): bool
    {
        return $user->schools->first()?->pivot?->role === 'admin';
    }
}
