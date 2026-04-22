<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController ;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ScheduleController;
Route::get('/', fn () => view('admin.dashboard'))->name('dashboard')->middleware('auth');


Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
Route::put('/student/update/{id}', [StudentController::class, 'update'])
    ->name('student.update');
Route::delete('/student/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
Route::get('/student/show/{id}', [StudentController::class, 'show'])->name('student.show');



Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');

Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');

Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');

Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');

Route::get('/classes/{id}/edit', [ClassController::class, 'edit'])->name('classes.edit');

Route::put('/classes/{id}', [ClassController::class, 'update'])->name('classes.update');

Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');


Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');



Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])
    ->name('schedule.delete');
Route::get('/schedule/{id}/students', [ScheduleController::class, 'viewClass'])
    ->name('schedule.viewClass');
    Route::get('/student/{id}/schedules', [ScheduleController::class, 'studentSchedule'])
    ->name('schedule.student.detail');
Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
