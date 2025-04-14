<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cohort extends Model
{
    protected $table = 'cohorts';

    protected $fillable = [
        'school_id',
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    public function students()
    {
        return $this->hasManyThrough(
            \App\Models\User::class,
            \App\Models\UserSchool::class,
            'cohort_id',
            'id',
            'id',
            'user_id'
        )->where('role', 'student');
    }


    public function school(): BelongsTo
    {
        return $this->belongsTo(\App\Models\School::class);
    }
}
