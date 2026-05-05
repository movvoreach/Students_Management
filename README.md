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
Route::get('/', fn() => view('admin.dashboard'))
    ->name('dashboard')
    ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Students
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

    // Classes
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index')->middleware('permission:view class');
        Route::get('/create', [ClassController::class, 'create'])->name('create')->middleware('permission:create class');
        Route::post('/', [ClassController::class, 'store'])->name('store')->middleware('permission:create class');
        Route::get('/{id}', [ClassController::class, 'show'])->name('show')->middleware('permission:view class');
        Route::get('/{id}/edit', [ClassController::class, 'edit'])->name('edit')->middleware('permission:edit class');
        Route::put('/{id}', [ClassController::class, 'update'])->name('update')->middleware('permission:edit class');
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
});


Route::middleware(['auth', 'role:teacher|student|admin'])->group(function () {


    // VIEW SCHEDULE (shared access)

    Route::get('/schedule', [ScheduleController::class, 'index'])
        ->name('schedule.index')
        ->middleware('permission:view schedule');

    // Detail view of a class schedule
    Route::get('/schedule/{id}/show', [ScheduleController::class, 'viewClass'])
        ->name('schedule.viewClass')
        ->middleware('permission:view schedule');


    // TEACHER  ADMIN

    Route::post('/schedule/store', [ScheduleController::class, 'store'])
        ->name('schedule.store')
        ->middleware('permission:create schedule');

    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])
        ->name('schedule.delete')
        ->middleware('permission:delete schedule');

    Route::delete('/schedule/{schedule}/student/{student}', [ScheduleController::class, 'removeStudent'])
        ->name('schedule.removeStudent')
        ->middleware('permission:edit schedule');

    Route::post('/schedule/enroll/students', [EnrollmentController::class, 'store'])
        ->name('enrollment.store')
        ->middleware('permission:create schedule');


    // AJAX

    Route::get('/get-subjects/{departmentId}', [ScheduleController::class, 'getSubjects'])
        ->middleware('permission:view schedule');

    Route::get('/get-teachers/{id}', [ScheduleController::class, 'getTeachers'])
        ->middleware('permission:view schedule');


    // STUDENT

    Route::get('/student/{id}/show', [ScheduleController::class, 'studentSchedule'])
        ->name('schedule.student.detail')
        ->middleware('permission:view schedule');
});

@extends('admin.layouts.master')

@section('title', 'Schedule Management System')

@section('content')

    <style>
        .content-wrapper,
        .content-wrapper h1,
        .content-wrapper h2,
        .content-wrapper h3,
        .content-wrapper p,
        .content-wrapper span,
        .content-wrapper table,
        .content-wrapper th,
        .content-wrapper td {
            font-family: 'Battambang', sans-serif !important;
        }

        /* Styles for timetable display */
        .timetable-table { /* Renamed from schedule-table to avoid conflict with admin table */
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .timetable-table th,
        .timetable-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            vertical-align: top;
            min-width: 120px; /* Adjust as needed */
        }

        .timetable-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .timetable-table .time-slot {
            background-color: #d8edf7; /* Light blue for time column */
            min-width: 100px;
            font-weight: bold;
        }

        .timetable-entry {
            background-color: #fff;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .timetable-entry span {
            display: block;
            font-size: 0.85em;
        }
        .timetable-entry .subject {
            font-weight: bold;
            color: #337ab7; /* Blue for subject */
        }
        .timetable-entry .teacher {
            color: #5cb85c; /* Green for teacher */
        }
        .timetable-entry .class-room {
            color: #888;
        }

        /* Specific styles for Admin's list view */
        #myTable th, #myTable td {
            text-align: center; /* Ensure alignment too */
        }
    </style>

    <section class="content mt-4">

        <!-- HEADER -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Schedule Management System (SMS)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Schedule</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- STATS -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ \App\Models\Schedule::count() ?? 0 }}</h3>
                            <p>Total Schedules</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ \App\Models\Classes::where('status', 'active')->count() ?? 0 }}</h3>
                            <p>Active Classes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ \App\Models\User::role('student')->count() ?? 0 }}</h3>
                            <p>Total Students</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ \App\Models\Classes::where('status', 'inactive')->count() ?? 0 }}</h3>
                            <p>Inactive</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOP ACTION with combined filter form -->
            <form method="GET" action="{{ route('schedule.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="Search Schedule..." value="{{ request('search') }}">
                    </div>

                    @role('admin')
                        <div class="col-md-2 mb-2">
                            <select name="department_id" class="form-control" onchange="this.form.submit()">
                                <option value="">All Departments</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <select name="teacher_id" class="form-control" onchange="this.form.submit()">
                                <option value="">All Teachers</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <select name="day" class="form-control" onchange="this.form.submit()">
                                <option value="">All Days</option>
                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $dayOption)
                                    <option value="{{ $dayOption }}"
                                        {{ request('day') == $dayOption ? 'selected' : '' }}>
                                        {{ $dayOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endrole

                    <div class="col-md-1 mb-2">
                        <button type="submit" class="btn btn-secondary w-100">
                            Apply
                        </button>
                    </div>

                    @hasanyrole('admin|teacher')
                    <div class="col-md-2 mb-2">
                        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#scheduleContainer">
                            Add Schedule +
                        </button>
                    </div>
                    @endhasanyrole
                </div>
            </form>

            @can('view schedule')
                <div class="row">
                    <div class="col-12">

                        @if (Auth::user()->hasRole('admin'))
                            {{-- ADMIN LIST/TABLE VIEW (Detailed) --}}
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold text-primary">
                                        <i class="fas fa-calendar-alt me-2"></i> Schedule List (Admin View)
                                    </h5>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0" id="myTable">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Department</th>
                                                    <th>Subject & Room</th> {{-- Combined --}}
                                                    <th>Teacher</th> {{-- Now separate --}}
                                                    <th>Time</th>
                                                    <th width="120">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody class="text-center">
                                                @forelse ($schedules as $schedule)
                                                    <tr>
                                                        <!-- Day -->
                                                        <td>{{ ucfirst($schedule->day) }}</td>

                                                        <!-- Department -->
                                                        <td>{{ $schedule->teacher->department->department_name ?? 'N/A' }}</td>

                                                        <!-- Subject & Room -->
                                                        <td>
                                                            <span class="fw-semibold text-primary">
                                                                {{ $schedule->subject->subject_name ?? 'N/A' }}, Room {{ $schedule->class->class_name ?? 'N/A' }}
                                                            </span>
                                                        </td>

                                                        <!-- Teacher -->
                                                        <td>
                                                            <span class="fw-semibold">
                                                                {{ $schedule->teacher->name ?? 'N/A' }}
                                                            </span>
                                                        </td>

                                                        <!-- Time -->
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                        </td>

                                                        <!-- Actions -->
                                                        <td>
                                                            @can('view schedule')
                                                                <div class="dropdown">
                                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown">
                                                                        Actions
                                                                    </button>

                                                                    <ul class="dropdown-menu shadow-sm border-0">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('schedule.viewClass', $schedule->id) }}">
                                                                                <i class="fa fa-eye text-info me-2"></i> View
                                                                            </a>
                                                                        </li>

                                                                        @can('edit schedule')
                                                                            <li>
                                                                                <a class="dropdown-item btnedit" href="#"
                                                                                    data-id="{{ $schedule->id }}">
                                                                                    <i class="fa fa-edit text-warning me-2"></i> Edit
                                                                                </a>
                                                                            </li>
                                                                        @endcan

                                                                        @can('delete schedule')
                                                                            <li>
                                                                                <hr class="dropdown-divider">
                                                                            </li>

                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('schedule.delete', $schedule->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')

                                                                                    <button type="submit" class="dropdown-item text-danger"
                                                                                        onclick="return confirm('Delete this schedule?')">
                                                                                        <i class="fas fa-trash me-2"></i> Delete
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                        @endcan
                                                                    </ul>
                                                                </div>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4 text-muted">
                                                            <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                                            No schedules found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="card-footer bg-white">
                                    {{ $schedules->links() }}
                                </div>
                            </div>

                        @elseif (Auth::user()->hasRole('teacher'))
                            {{-- TEACHER LIST VIEW (YOUR PROVIDED CODE) --}}
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">My Schedule (Teacher View)</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Time</th>
                                                    <th>Subject</th>
                                                    <th>Class</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($schedules as $schedule)
                                                    <tr>
                                                        <td>{{ $schedule->day }}</td>
                                                        <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                                        <td>{{ $schedule->subject->subject_name ?? '-' }}</td>
                                                        <td>Room {{ $schedule->class->class_name ?? '-' }}</td>
                                                        <td>
                                                            @can('view schedule')
                                                                <span class="dropdown">
                                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                    Actions
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="{{ route('schedule.viewClass', $schedule->id) }}">
                                                                            <i class="fa fa-eye"></i> View Details
                                                                        </a>
                                                                         @can('edit schedule')
                                                                            <a class="dropdown-item btnedit" href="#" data-id="{{ $schedule->id }}">
                                                                                <i class="fa fa-edit text-primary"></i> Edit Schedule
                                                                            </a>
                                                                         @endcan
                                                                         @can('delete schedule')
                                                                            <div class="dropdown-divider"></div>
                                                                            <form action="{{ route('schedule.delete', $schedule->id) }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="dropdown-item text-danger"
                                                                                    onclick="return confirm('Do you want to delete this schedule?')">
                                                                                    <i class="fas fa-trash"></i> Delete
                                                                                </button>
                                                                            </form>
                                                                         @endcan
                                                                    </div>
                                                                </span>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">No schedule found for you.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @elseif (Auth::user()->hasRole('student'))
                            {{-- STUDENT TIMETABLE VIEW --}}
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">My Class Timetable (Student View)</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="timetable-table">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Time</th>
                                                    @foreach ($days as $day)
                                                        <th>{{ $day }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($time->isEmpty())
                                                    <tr>
                                                        <td colspan="{{ count($days) + 1 }}" class="text-muted">No schedule entries for your courses.</td>
                                                    </tr>
                                                @else
                                                    @foreach ($time as $timeSlot)
                                                        <tr>
                                                            <td class="time-slot">{{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}</td>
                                                            @foreach ($days as $day)
                                                                <td>
                                                                    @php
                                                                        $items = $schedules->where('day', $day)
                                                                                            ->where('start_time', $timeSlot->start_time)
                                                                                            ->where('end_time', $timeSlot->end_time);
                                                                    @endphp
                                                                    @forelse ($items as $schedule)
                                                                        <div class="timetable-entry">
                                                                            <span class="subject">{{ $schedule->subject->subject_name ?? '-' }}</span>
                                                                            <span class="teacher">({{ $schedule->teacher->name ?? '-' }})</span>
                                                                            <span class="class-room">Room {{ $schedule->class->class_name ?? '-' }}</span>
                                                                        </div>
                                                                    @empty
                                                                        <span class="text-muted">-</span>
                                                                    @endforelse
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endcan
            <!-- CREATE SCHEDULE MODAL -->
            @hasanyrole('admin|teacher')
            <div class="modal fade" id="scheduleContainer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Create Schedule</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Department</label>
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value="" selected hidden>Choose Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Subject</label>
                                        <select name="subject_id" id="subject" class="form-control" required>
                                            <option value="" selected hidden>-- Select Subject --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="teacher" class="form-control" required>
                                            <option value="" selected hidden>-- Select Teacher --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Class</label>
                                        <select name="class_id" id="classes" class="form-control" required>
                                            <option value="" selected hidden>-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Day</label>
                                        <select name="day" class="form-control" required>
                                            <option value="" selected hidden>-- Select Day --</option>
                                            <option>Monday</option>
                                            <option>Tuesday</option>
                                            <option>Wednesday</option>
                                            <option>Thursday</option>
                                            <option>Friday</option>
                                            <option>Saturday</option>
                                            <option>Sunday</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Start Time</label>
                                        <input type="time" name="start_time" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Schedule</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endhasanyrole

            <!-- EDIT SCHEDULE MODAL -->
            @hasanyrole('admin|teacher')
            <div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form id="editScheduleForm" method="POST">
                        @csrf
                        @method('PUT') {{-- Use PUT method for updates --}}

                        <div class="modal-content">
                            <!-- HEADER -->
                            <div class="modal-header bg-warning text-white"> {{-- Changed color for edit --}}
                                <h5 class="modal-title">Edit Schedule</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <!-- BODY -->
                            <div class="modal-body">
                                <div class="row">
                                    <!-- DEPARTMENT -->
                                    <div class="col-md-6 mb-3">
                                        <label>Department</label>
                                        <select name="department_id" id="edit_department_id" class="form-control" required>
                                            <option value="" selected hidden>Choose Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- SUBJECT -->
                                    <div class="col-md-6 mb-3">
                                        <label>Subject</label>
                                        <select name="subject_id" id="edit_subject" class="form-control" required>
                                            <option value="" selected hidden>-- Select Subject --</option>
                                            {{-- Subjects will be loaded dynamically by JS --}}
                                        </select>
                                    </div>
                                    <!-- TEACHER -->
                                    <div class="col-md-6 mb-3">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="edit_teacher" class="form-control" required>
                                            <option value="" selected hidden>-- Select Teacher --</option>
                                            {{-- Teachers will be loaded dynamically by JS --}}
                                        </select>
                                    </div>
                                    <!-- CLASS -->
                                    <div class="col-md-6 mb-3">
                                        <label>Class</label>
                                        <select name="class_id" id="edit_classes" class="form-control" required>
                                            <option value="" selected hidden>-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- DAY -->
                                    <div class="col-md-6 mb-3">
                                        <label>Day</label>
                                        <select name="day" id="edit_day" class="form-control" required>
                                            <option value="" selected hidden>-- Select Day --</option>
                                            <option>Monday</option>
                                            <option>Tuesday</option>
                                            <option>Wednesday</option>
                                            <option>Thursday</option>
                                            <option>Friday</option>
                                            <option>Saturday</option>
                                            <option>Sunday</option>
                                        </select>
                                    </div>
                                    <!-- START TIME -->
                                    <div class="col-md-3 mb-3">
                                        <label>Start Time</label>
                                        <input type="time" name="start_time" id="edit_start_time" class="form-control" required>
                                    </div>
                                    <!-- END TIME -->
                                    <div class="col-md-3 mb-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" id="edit_end_time" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">Update Schedule</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endhasanyrole


            <!-- ENROLL STUDENT MODALS -->
            @can('edit schedule')
                @foreach ($schedules as $schedule)
                    <div class="modal fade" id="enrollModal{{ $schedule->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('enrollment.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="class_id" value="{{ $schedule->class->id }}">
                                <input class="schedule_id" type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Enroll Student for {{ $schedule->class->class_name ?? 'N/A' }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <select name="student_id" class="form-control select2-student js-example-basic-single" required>
                                            <option value="" disabled selected>Select Student</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary">Enroll</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endcan

        </div> {{-- End container-fluid --}}
    </section>

@endsection

@push('scripts') {{-- Use @push('scripts') to avoid conflicts and keep scripts at the end of the body --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Select2 initialization for Enroll Student modal
        $(document).on('shown.bs.modal', function() { // General listener for any modal showing
            var $modal = $(this);
            $modal.find('.select2-student').each(function() {
                if (!$(this).data('select2')) { // Initialize only if not already initialized
                    $(this).select2({
                        dropdownParent: $modal, // Crucial for select2 inside bootstrap modals
                        placeholder: "Search student...",
                        width: '100%',
                        allowClear: true // Allow clearing of selection
                    });
                }
            });
        });

        // Dynamic Student loading for Enroll Student modal
        $(document).on('click', '.dropdown-item.btnadd', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var scheduleId = $(this).data('schedule-id'); // Get schedule ID from data attribute
            if (!scheduleId) {
                console.error("Schedule ID not found for Enroll Student button.");
                return;
            }

            var $enrollModal = $('#enrollModal' + scheduleId);
            var $select2Student = $enrollModal.find('.js-example-basic-single');

            // Clear previous options and show loading state
            $select2Student.empty().append('<option value="" disabled selected>Loading Students...</option>');

            // Show the modal first to correctly attach dropdownParent for Select2
            $enrollModal.modal('show');

            $.ajax({
                url: "/check-student?" + $.param({
                    schedule_id: scheduleId
                }),
                method: "GET",
                dataType: "json",
                success: function(response) {
                    $select2Student.empty().append('<option value="" disabled selected>Select Student</option>'); // Re-add placeholder
                    if (response && response.length > 0) {
                        response.forEach(function(item) {
                            var newOption = new Option(item.text, item.id, false, false);
                            $select2Student.append(newOption);
                        });
                    } else {
                         console.warn("No students found or loaded for this schedule.");
                         $select2Student.append('<option value="" disabled>No students available</option>');
                    }
                    $select2Student.trigger('change'); // Notify select2 of changes
                },
                error: function(xhr, status, error) {
                    console.error("Error loading students:", error);
                    $select2Student.empty().append('<option value="" disabled selected>Error loading students</option>');
                    $select2Student.trigger('change');
                }
            });
            // Update the hidden schedule_id input in the modal
            $enrollModal.find('input.schedule_id').val(scheduleId);
        });


        // Dependent Dropdowns for Create Schedule Modal
        $('#department_id').on('change', function() {
            let deptId = $(this).val();
            let $subjectSelect = $('#subject');
            let $teacherSelect = $('#teacher');

            // Clear and set loading states for both
            $subjectSelect.empty().append('<option value="" selected hidden>Loading Subjects...</option>');
            $teacherSelect.empty().append('<option value="" selected hidden>Loading Teachers...</option>');

            if (deptId) {
                // Fetch Subjects
                $.ajax({
                    url: '/get-subjects/' + deptId,
                    method: 'GET',
                    success: function(data) {
                        $subjectSelect.empty().append('<option value="" selected hidden>-- Select Subject --</option>');
                        $.each(data, function(key, subject) {
                            $subjectSelect.append('<option value="' + subject.id + '">' + subject.subject_name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading subjects:", error);
                        $subjectSelect.empty().append('<option value="" selected hidden>Error loading subjects</option>');
                    }
                });

                // Fetch Teachers
                // Assuming get-teachers now expects departmentId as well
                $.ajax({
                    url: '/get-teachers/' + deptId,
                    type: 'GET',
                    success: function(data) {
                        $teacherSelect.empty().append('<option value="" selected hidden>-- Select Teacher --</option>');
                        $.each(data, function(key, value) {
                            $teacherSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading teachers:", error);
                        $teacherSelect.empty().append('<option value="" selected hidden>Error loading teachers</option>');
                    }
                });
            } else {
                // If no department selected, revert to default placeholders
                $subjectSelect.empty().append('<option value="" selected hidden>-- Select Subject --</option>');
                $teacherSelect.empty().append('<option value="" selected hidden>-- Select Teacher --</option>');
            }
        });

        // Dependent Dropdowns for EDIT Schedule Modal
        $('#edit_department_id').on('change', function() {
            let deptId = $(this).val();
            let $subjectSelect = $('#edit_subject');
            let $teacherSelect = $('#edit_teacher');
            let currentSubjectId = $subjectSelect.data('current-value'); // Get stored value
            let currentTeacherId = $teacherSelect.data('current-value'); // Get stored value


            $subjectSelect.empty().append('<option value="" selected hidden>Loading Subjects...</option>');
            $teacherSelect.empty().append('<option value="" selected hidden>Loading Teachers...</option>');

            if (deptId) {
                // Fetch Subjects
                $.ajax({
                    url: '/get-subjects/' + deptId,
                    method: 'GET',
                    success: function(data) {
                        $subjectSelect.empty().append('<option value="" selected hidden>-- Select Subject --</option>');
                        $.each(data, function(key, subject) {
                            $subjectSelect.append('<option value="' + subject.id + '">' + subject.subject_name + '</option>');
                        });
                        // Select the current subject after options are loaded
                        if (currentSubjectId) {
                            $subjectSelect.val(currentSubjectId);
                            $subjectSelect.removeData('current-value'); // Clear data
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading subjects for edit:", error);
                        $subjectSelect.empty().append('<option value="" selected hidden>Error loading subjects</option>');
                    }
                });

                // Fetch Teachers
                $.ajax({
                    url: '/get-teachers/' + deptId,
                    type: 'GET',
                    success: function(data) {
                        $teacherSelect.empty().append('<option value="" selected hidden>-- Select Teacher --</option>');
                        $.each(data, function(key, value) {
                            $teacherSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Select the current teacher after options are loaded
                        if (currentTeacherId) {
                            $teacherSelect.val(currentTeacherId);
                            $teacherSelect.removeData('current-value'); // Clear data
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading teachers for edit:", error);
                        $teacherSelect.empty().append('<option value="" selected hidden>Error loading teachers</option>');
                    }
                });
            } else {
                $subjectSelect.empty().append('<option value="" selected hidden>-- Select Subject --</option>');
                $teacherSelect.empty().append('<option value="" selected hidden>-- Select Teacher --</option>');
            }
        });

        // Edit button click handler
        $(document).on('click', '.btnedit', function() {
            var id = $(this).data('id'); // Get the schedule ID from the button's data-id attribute

            $.ajax({
                url: '/schedule/' + id + '/edit', // This should be your GET endpoint to fetch schedule data for editing
                type: 'GET',
                success: function(data) {
                    console.log(data); // Log data to inspect its structure

                    // Set form action for the update
                    $('#editScheduleForm').attr('action', '/schedule/update/' + data.id); // Assuming this route exists

                    // Store current values for dependent dropdowns before triggering change
                    $('#edit_subject').data('current-value', data.subject_id);
                    $('#edit_teacher').data('current-value', data.teacher_id);


                    // Set department, and then trigger its change event to load subjects and teachers
                    // The 'data-current-value' logic in the change handler will pick up the correct values
                    $('#edit_department_id').val(data.teacher.department_id).trigger('change');

                    // Fill other inputs directly
                    $('#edit_classes').val(data.class_id);
                    $('#edit_day').val(data.day);
                    $('#edit_start_time').val(data.start_time.substring(0, 5));
                    $('#edit_end_time').val(data.end_time.substring(0, 5));

                    // Show modal (Bootstrap 4)
                    $('#editScheduleModal').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Error loading schedule data for editing');
                }
            });
        });


    });
</script>
@endpush
