<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Cohort extends Model
{
    // …

    /**
     * Les étudiants rattachés à la promotion via la table pivot users_schools
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'users_schools',    // la table pivot
            'cohort_id',        // FK vers cohorts
            'user_id'           // FK vers users
        )
            ->withPivot('role')
            ->wherePivot('role','student');
    }

    /**
     * Le professeur responsable, colonne teacher_id sur cohorts
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * L’école liée (si vous avez un modèle School)
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
