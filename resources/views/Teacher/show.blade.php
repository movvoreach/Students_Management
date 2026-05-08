@extends('admin.layouts.master')

@section('title', 'Teacher Information')

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
                <h1 class="m-0">Teacher Information</h1>
                <p class="text-muted">Teacher profile and assigned class schedules</p>
            </div>
        </div>

        <div class="container-fluid">

            {{-- TEACHER INFO --}}
            <div class="card border-0 shadow-sm mb-4 mt-4">
                <div class="card-body p-4">

                    <div class="text-center mb-3">

                        {{-- PROFILE IMAGE --}}
                        <div class="mb-3">
                            <img src="{{ $teacher->image ? asset('storage/' . $teacher->image) : asset('images/default-user.png') }}"
                                alt="Teacher Profile" class="shadow border"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        </div>

                        {{-- NAME --}}
                        <h3 class="fw-bold text-dark mb-1">
                            {{ $teacher->name ?? 'N/A' }}
                        </h3>

                        {{-- SUB TITLE --}}
                        <span class="text-muted">
                            Teacher Information Detail
                        </span>

                    </div>

                    <hr class="my-3">

                    {{-- INFO GRID --}}
                    <div class="row g-3 text-center">

                        {{-- Teacher Code --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Teacher Code</small>
                                <div class="fw-semibold text-dark">
                                    {{ $teacher->teacher_code ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Gender</small>
                                <div class="fw-semibold text-dark">
                                    {{ $teacher->gender ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Subject</small>
                                <div class="fw-semibold text-dark">
                                    {{ $teacher->subject ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-3">
                            <div class="p-2">
                                <small class="text-muted d-block">Phone</small>
                                <div class="fw-semibold text-dark">
                                    {{ $teacher->phone ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Email</small>
                                <div class="fw-semibold text-dark">
                                    {{ $teacher->email ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Date of Birth --}}
                        <div class="col-md-6">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Date of Birth</small>
                                <div class="fw-semibold text-dark">
                                    {{ $teacher->dob ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- CLASS LIST --}}
            <div class="card">

                <div class="card-header bg-white">
                    <strong>Assigned Class Schedule</strong>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Class Name</th>
                                <th>Total Students</th>
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

                                    {{-- STUDENT COUNT --}}
                                    <td class="text-center">
                                        {{ $schedule->students->count() ?? 0 }}
                                    </td>

                                    {{-- SUBJECT --}}
                                    <td>
                                        {{ $schedule->subject->subject_name ?? 'N/A' }}
                                    </td>

                                    {{-- SCHEDULE --}}
                                    <td class="text-success font-weight-bold">
                                        {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        <div class="text-muted small">
                                            {{ $schedule->day }}
                                        </div>
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center">
                                        <span class="badge badge-success">Active</span>
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="text-center">
                                        <a href="{{ route('schedule.show', $schedule->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="#" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No assigned classes found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="card-footer">
                    Total Assigned Classes: {{ $schedules->count() }}
                </div>

            </div>

        </div>

    </section>

@endsection
