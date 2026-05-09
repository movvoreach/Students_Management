<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Students
    Route::prefix('student')
        ->name('student.')
        ->group(function () {

            Route::get('/', [StudentController::class, 'index'])
                ->name('index')
                ->middleware('permission:view student');

            Route::get('/create', [StudentController::class, 'create'])
                ->name('create')
                ->middleware('permission:create student');

            Route::post('/store', [StudentController::class, 'store'])
                ->name('store')
                ->middleware('permission:create student');

            Route::get('/{student}/show', [StudentController::class, 'show'])
                ->name('show')
                ->middleware('permission:view student');

            Route::get('/{student}/edit', [StudentController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:edit student');

            Route::put('/{student}/update', [StudentController::class, 'update'])
                ->name('update')
                ->middleware('permission:edit student');

            Route::delete('/{student}/delete', [StudentController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:delete student');
        });

    Route::get('/check-student', [StudentController::class, 'checkStudent'])
        ->middleware('permission:view student');

    // Classes
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index')->middleware('permission:view class');
        Route::get('/create', [ClassController::class, 'create'])->name('create')->middleware('permission:create class');
        Route::post('/', [ClassController::class, 'store'])->name('store')->middleware('permission:create class');
        Route::get('/{id}', [ClassController::class, 'show'])->name('show')->middleware('permission:view class');
        Route::get('/{id}/edit', [ClassController::class, 'edit'])->name('edit')->middleware('permission:edit class');
        Route::put('/{classroom}', [ClassController::class, 'update'])->name('update')->middleware('permission:edit class');
        Route::delete('/{id}', [ClassController::class, 'destroy'])->name('destroy')->middleware('permission:delete class');
    });

    // Teachers
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index')->middleware('permission:view teacher');
        Route::get('/create', [TeacherController::class, 'create'])->name('create')->middleware('permission:create teacher');
        Route::post('/', [TeacherController::class, 'store'])->name('store')->middleware('permission:create teacher');
        Route::get('/{id}', [TeacherController::class, 'show'])->name('show')->middleware('permission:view teacher');
        Route::get('/{id}/edit', [TeacherController::class, 'edit'])->name('edit')->middleware('permission:edit teacher');
        Route::put('/{id}', [TeacherController::class, 'update'])->name('update')->middleware('permission:edit teacher');
        Route::delete('/{id}', [TeacherController::class, 'destroy'])->name('destroy')->middleware('permission:delete teacher');
    });
    //Departments

    // Subjects
    Route::resource('subjects', SubjectController::class)->middleware('permission:view subject');

    // Schedules
     Route::group([
        'prefix'=> 'schedule',
        'as' => 'schedule.',
    ], function () {
        Route::get('/', [ScheduleController::class, 'index'])
            ->name('index')
            ->middleware('permission:view schedule');

        Route::get('/create', [ScheduleController::class, 'create'])
            ->name('create')
            ->middleware('permission:create schedule');

        Route::post('/store', [ScheduleController::class, 'store'])
            ->name('store')
            ->middleware('permission:create schedule');

        Route::get('/{schedule}/show', [ScheduleController::class, 'show'])
            ->name('show')
            ->middleware('permission:edit student');

        Route::get('/{schedule}/edit', [ScheduleController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:edit student');

        Route::put('/{schedule}/update', [ScheduleController::class, 'update'])
            ->name('update')
            ->middleware('permission:edit student');

        Route::delete('/{schedule}/delete', [ScheduleController::class, 'destroy'])
            ->name('delete')
            ->middleware('permission:delete student');

        Route::delete('/{schedule}/students/{student}/unenroll', [ScheduleController::class, 'unEnrollStudent'])
            ->name('remove.student')
            ->middleware('permission:delete student');
    });
});
