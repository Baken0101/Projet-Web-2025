<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSchool extends Model
{
    protected $table = 'users_schools';

    protected $fillable = ['user_id', 'school_id', 'cohort_id', 'role'];

    // Relation vers la formation (cohort)
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers l'école
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

