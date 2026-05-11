@extends('admin.layouts.master')

@section('title', 'Student Management System')

@section('content')

    <style>
        .content-wrapper,
        .content-wrapper h1,
        .content-wrapper h2,
        .content-wrapper h3,
        .content-wrapper h4,
        .content-wrapper h5,
        .content-wrapper h6,
        .content-wrapper p,
        .content-wrapper span,
        .content-wrapper a,
        .content-wrapper table,
        .content-wrapper th,
        .content-wrapper td,
        .breadcrumb {
            font-family: 'Battambang', sans-serif !important;
        }

        .content-wrapper h1,
        .content-wrapper .card-title {
            font-weight: 600;
        }

        .small-box .inner h3 {
            font-weight: 500;
        }
    </style>

    <section class="content mt-4">

        <!-- CONTENT HEADER -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student Management System (SMS)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Management System</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">



                <!-- STATS ROW 1 -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $studentsCount }}</h3>
                                <p>Total Students</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $classesCount }}</h3>
                                <p>Total Classes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $enrollmentCount }}</h3>
                                <p>Total Enrollment</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalSchedules }}</h3>
                                <p>Total Schedules</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- STATS ROW 2 -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-school"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Classes</span>
                                <span class="info-box-number">{{ $classesCount }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-chalkboard-teacher"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Teachers</span>
                                <span class="info-box-number">{{ $teachersCount }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-book"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Subjects</span>
                                <span class="info-box-number">{{ $tatalSubject }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"> Total Departments</span>
                                <span class="info-box-number">{{ $totalDepartment }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TABLES -->
                <!-- RECENT STUDENTS -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-user-graduate mr-1"></i>
                                Recent Students
                            </h3>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($enrollments as $enrollment)
                                        <tr>
                                            <td>{{ $enrollment->student->name}}</td>
                                            <td>{{ $enrollment->schedule->class->class_name }}</td>
                                            <td>{{ $enrollment->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    Active
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                No enrollments found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </section>

@endsection
