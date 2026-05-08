@extends('admin.layouts.master')

@section('title', 'Student Schedule')

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
    </style>

    <section class="content mt-4">

        <!-- HEADER -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">My Class</h1>
                <p class="text-muted">All classes you are enrolled in</p>
            </div>
        </div>

        <div class="container-fluid">

            {{-- STUDENT INFO --}}
            <div class="card border-0 shadow-sm mb-4 mt-4">

                <div class="card-body p-4">

                    {{-- TITLE SECTION --}}
                    <div class="text-center mb-3">
                        <h3 class="fw-bold text-dark mb-1">
                            {{ $student->name ?? 'N/A' }}
                        </h3>

                        <span class="text-muted">
                            Student Information Detail
                        </span>
                    </div>

                    <hr class="my-3">

                    {{-- INFO GRID --}}
                    <div class="row g-3 text-center">

                        {{-- Student Code --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Student Code</small>
                                <div class="fw-semibold text-dark">
                                    {{ $student->student_code ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Gender</small>
                                <div class="fw-semibold text-dark">
                                    {{ $student->gender ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Class --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Class</small>
                                <div class="fw-semibold text-dark">
                                    {{ $student->class->class_name ?? 'No Class Assigned' }}
                                </div>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Phone</small>
                                <div class="fw-semibold text-dark">
                                    {{ $student->phone ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Email</small>
                                <div class="fw-semibold text-dark">
                                    {{ $student->email ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Date of Birth --}}
                        <div class="col-md-6">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Date of Birth</small>
                                <div class="fw-semibold text-dark">
                                    {{ $student->dob ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            {{-- CLASS LIST --}}
            <div class="card">

                <div class="card-header bg-white">

                    <strong>Class List</strong>

                    {{-- BUTTON (optional create class / enroll) --}}
                    {{-- <a href="#" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus"></i>
                    </a> --}}

                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Class Name</th>
                                <th>Teacher</th>
                                <th>Subject</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($schedules as $key => $schedule)
                                <tr>

                                    {{-- NO --}}
                                    <td class="text-center">
                                        {{ $key + 1 }}
                                    </td>

                                    {{-- CLASS NAME --}}
                                    <td>
                                        <strong>{{ $schedule->class->class_name ?? 'N/A' }}</strong>
                                        <div class="text-muted small">
                                            ID: {{ $schedule->class->id ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- TEACHER --}}
                                    <td>
                                        {{ $schedule->teacher->name ?? 'N/A' }}
                                    </td>

                                    {{-- SUBJECT --}}
                                    <td>
                                        {{ $schedule->subject->subject_name ?? 'English' }}
                                    </td>

                                    {{-- SCHEDULE TIME --}}
                                    <td class="text-success font-weight-bold">
                                        {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        <div class="text-muted small">
                                            {{ $schedule->day }}
                                        </div>
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        <span class="badge badge-success">Active</span>
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="text-center">

                                        <a href="{{ route('schedule.viewClass', $schedule->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- <a href="#" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a> --}}

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No class found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="card-footer">
                    Total Classes: {{ $schedules->count() }}
                </div>

            </div>

        </div>

    </section>

@endsection
