<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashbordsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', [DashbordsController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth']);
// Route::get('/', fn() => view('admin.dashboard'))
//     ->name('dashboard')
//     ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

include __DIR__.'/backend/admin.php';


Route::middleware(['auth', 'role:teacher|student|admin'])->group(function () {


    // AJAX for enrollment
    Route::post('/schedule/enroll/students', [ScheduleController::class, 'storeEnrollment'])->name('enrollment.store')->middleware('permission:create schedule');

    // AJAXschedule.edit

    Route::get('/get-subjects/{departmentId}', [ScheduleController::class, 'getSubjects'])->middleware('permission:view schedule');

    Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');

    Route::put('/schedule/update/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');

    Route::get('/get-teachers/{id}', [ScheduleController::class, 'getTeachers'])->middleware('permission:view schedule');

    // STUDENT
    // Route::get('/student/{id}/show', [ScheduleController::class, 'studentSchedule'])->name('schedule.student.detail')->middleware('permission:view schedule');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show')->middleware('permission:view profile');

    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('permission:edit profile');

    Route::put('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('permission:edit profile');

});
