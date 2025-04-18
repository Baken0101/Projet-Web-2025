<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getShortNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name[0] . '.';
    }

    /**
     * Relation many-to-many entre users et schools avec infos supplémentaires.
     */
    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(
            School::class,
            'users_schools',
            'user_id',
            'school_id'
        )
            ->withPivot('role', 'cohort_id')
            ->withTimestamps();
    }

    /**
     * Accès direct au pivot UserSchool
     */
    public function userSchools(): HasMany
    {
        return $this->hasMany(UserSchool::class);
    }

    public function teachingCohorts()
    {
        return $this->hasMany(Cohort::class, 'teacher_id');
    }
}
