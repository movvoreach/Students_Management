
<?php

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ClassController;
    use App\Http\Controllers\EnrollmentController;
    use App\Http\Controllers\ScheduleController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\TeacherController;
    use Illuminate\Support\Facades\Route;

    /*
|--------------------------------------------------------------------------
| Authentication Routes
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
    Route::get('/', fn() => view('admin.dashboard'))
    ->name('dashboard')
    ->middleware(['auth']);

    /*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index')->middleware('permission:view student');
        Route::get('/create', [StudentController::class, 'create'])->name('create')->middleware('permission:create student');
        Route::post('/store', [StudentController::class, 'store'])->name('store')->middleware('permission:create student');
        Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('edit')->middleware('permission:edit student');
        Route::put('/update/{student}', [StudentController::class, 'update'])->name('update')->middleware('permission:edit student');
        Route::delete('/delete/{student}', [StudentController::class, 'destroy'])->name('destroy')->middleware('permission:delete student');
    });

    Route::get('/check-student', [StudentController::class, 'checkStudent'])
        ->middleware('permission:view student');

    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index');
        Route::get('/create', [ClassController::class, 'create'])->name('create');
        Route::post('/', [ClassController::class, 'store'])->name('store');
        Route::get('/{id}', [ClassController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ClassController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClassController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClassController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index')->middleware('permission:view teacher');
        Route::get('/create', [TeacherController::class, 'create'])->name('create')->middleware('permission:create teacher');
        Route::post('/', [TeacherController::class, 'store'])->name('store')->middleware('permission:create teacher');
        Route::get('/{id}', [TeacherController::class, 'show'])->name('show')->middleware('permission:view teacher');
        Route::get('/{id}/edit', [TeacherController::class, 'edit'])->name('edit')->middleware('permission:edit teacher');
        Route::put('/{id}', [TeacherController::class, 'update'])->name('update')->middleware('permission:edit teacher');
        Route::delete('/{id}', [TeacherController::class, 'destroy'])->name('destroy')->middleware('permission:delete teacher');
    });
    });

    Route::middleware(['auth', 'role:teacher|admin'])->group(function () {

    Route::get('/schedule', [ScheduleController::class, 'index'])
        ->name('schedule.index')
        ->middleware('permission:view schedule');

    Route::post('/schedule/store', [ScheduleController::class, 'store'])
        ->name('schedule.store')
        ->middleware('permission:create schedule');

    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])
        ->name('schedule.delete')
        ->middleware('permission:delete schedule');

    Route::get('/schedule/{id}/show', [ScheduleController::class, 'viewClass'])
        ->name('schedule.viewClass')
        ->middleware('permission:view schedule');

    Route::delete('/schedule/{schedule}/student/{student}', [ScheduleController::class, 'removeStudent'])
        ->name('schedule.removeStudent')
        ->middleware('permission:edit schedule');

    Route::post('/schedule/enroll/students', [EnrollmentController::class, 'store'])
        ->name('enrollment.store')
        ->middleware('permission:create schedule');

    Route::get('/get-subjects/{departmentId}', [ScheduleController::class, 'getSubjects']);
    Route::get('/get-teachers/{id}', [ScheduleController::class, 'getTeachers']);
    });

    Route::middleware(['auth', 'role:student|admin'])->group(function () {

    Route::get('/student/{id}/show', [ScheduleController::class, 'studentSchedule'])->name('schedule.student.detail')->middleware('permission:view schedule');
    Route::get('/schedule', [ScheduleController::class, 'index'])
        ->name('schedule.index')
        ->middleware('permission:view schedule');

});
