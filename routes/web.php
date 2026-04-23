<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController ;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ScheduleController;
Route::get('/', fn () => view('admin.dashboard'))->name('dashboard')->middleware('auth');


Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/create', [StudentController::class, 'create'])->name('create');
    Route::post('/store', [StudentController::class, 'store'])->name('store');
    Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('edit');
    Route::put('/update/{student}', [StudentController::class, 'update'])->name('update');
    Route::delete('/delete/{student}', [StudentController::class, 'destroy'])->name('destroy');
    Route::get('/show/{student}', [StudentController::class, 'show'])->name('show');
    Route::get('/students/search', [StudentController::class, 'search'])->name('search');
    Route::get('/student/{id}/show', [StudentController::class, 'show'])
    ->name('detail');
    // Route::get('/students/filter', [StudentController::class, 'filtter'])->name('filter');


});



Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');

Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');

Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');

Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');

Route::get('/classes/{id}/edit', [ClassController::class, 'edit'])->name('classes.edit');

Route::put('/classes/{id}', [ClassController::class, 'update'])->name('classes.update');

Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');


Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::delete('/teachers/{id}/search', [TeacherController::class, 'getOne'])->name('teachers.getone');
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
 Route::get('/teachers/search', [TeacherController::class, 'search'])->name('teacher.search');




Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])
    ->name('schedule.delete');
Route::get('/schedule/{id}/students', [ScheduleController::class, 'viewClass'])
    ->name('schedule.viewClass');
    Route::get('/student/{id}/show', [ScheduleController::class, 'studentSchedule'])
    ->name('schedule.student.detail');
Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
