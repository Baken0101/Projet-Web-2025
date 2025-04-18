<?php

use App\Http\Controllers\CohortController;
use App\Http\Controllers\CommonLifeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetroController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile',   [ProfileController::class, 'edit']   )->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'] )->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Cohorts
        Route::get(   '/cohorts',                     [CohortController::class, 'index']      )->name('cohort.index');
        Route::post(  '/cohorts-create',              [CohortController::class, 'create']     )->name('cohort.create');
        Route::get(   '/cohort/{cohort}',             [CohortController::class, 'show']       )->name('cohort.show');
        Route::post(  '/cohort/{cohort}/add-student', [CohortController::class, 'addStudent'])->name('cohort.addStudent');
        Route::post(  '/cohort/{cohort}/edit',        [CohortController::class, 'updateAjax'])->name('cohort.update.ajax');
        Route::put(   '/cohort/{cohort}/update',      [CohortController::class, 'update']     )->name('cohort.update');
        Route::delete('/cohort/{cohort}',             [CohortController::class, 'destroy']    )->name('cohort.destroy');

        // **Teachers**
        Route::get('/teachers',       [TeacherController::class, 'index'])
            ->middleware('can:viewAny,App\Models\User')
            ->name('teacher.index');

        Route::post('/teachers',      [TeacherController::class, 'store'])
            ->middleware('can:create,App\Models\User')
            ->name('teacher.store');

        Route::post('/teachers/{teacher}/ajax', [TeacherController::class, 'updateAjax'])
            ->middleware('can:update,teacher')
            ->name('teacher.update.ajax');

        Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])
            ->middleware('can:update,teacher')
            ->name('teacher.update');

        Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])
            ->middleware('can:delete,teacher')
            ->name('teacher.destroy');

        // Students
        Route::get(   '/students',                 [StudentController::class, 'index']         )->name('student.index');
        Route::get(   '/students/create',          [StudentController::class, 'showCreateForm'])->name('student.create.form');
        Route::post(  '/students',                 [StudentController::class, 'create']        )->name('student.create');
        Route::get(   '/students/{student}/edit',  [StudentController::class, 'edit']          )->name('student.edit');
        Route::put(   '/students/{student}',       [StudentController::class, 'update']        )->name('student.update');
        Route::delete('/students/{student}',       [StudentController::class, 'destroy']       )->name('student.destroy');

        // Knowledge, Groups, Retros, Common life...
        Route::get('/knowledge',    [KnowledgeController::class, 'index'])->name('knowledge.index');
        Route::get('/groups',       [GroupController::class, 'index'])->name('group.index');
        Route::get('/retros',       [RetroController::class, 'index'])->name('retro.index');
        Route::get('/common-life',  [CommonLifeController::class, 'index'])->name('common-life.index');
    });
});

require __DIR__.'/auth.php';
