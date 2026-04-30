<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# Working
# Working1
# SMS
    // Enrollment::create([
        //     'student_id'  => $request->student_id,
        //     'class_id'    => $request->class_id,
        //     'schedule_id' => $request->schedule_id,
        // ]);
         // Student::where('id', $request->student_id)->update([
        //     'class_id' => $request->class_id,
        // ]);



 
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;

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
Route::get('/', fn () => view('admin.dashboard'))
    ->name('dashboard')
    ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Student Management
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Class Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index');
        Route::get('/create', [ClassController::class, 'create'])->name('create');
        Route::post('/', [ClassController::class, 'store'])->name('store');
        Route::get('/{id}', [ClassController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ClassController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClassController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClassController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Teacher Management
    |--------------------------------------------------------------------------
    */
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

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student|admin'])->group(function () {

    Route::get('/student/{id}/show', [ScheduleController::class, 'studentSchedule'])
        ->name('schedule.student.detail')
        ->middleware('permission:view schedule');
});





 foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
