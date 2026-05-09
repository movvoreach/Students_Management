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
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Schedule</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <!-- ERRORS -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FILTER / ACTION -->
            <form method="GET" action="{{ route('schedule.index') }}" class="mb-3">
                <div class="row">

                    @role('admin')
                        <div class="col-md-3 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search Schedule..."
                                value="{{ request('search') }}">
                        </div>

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

                        <div class="col-md-1 mb-2">
                            <button type="submit" class="btn btn-secondary w-100">
                                Filter
                            </button>
                        </div>
                    @endrole

                    @hasanyrole('admin|teacher')
                        @can('create schedule')
                            <div class="col-md-2 mb-2">
                                <button type="button" class="btn btn-primary w-100" data-toggle="modal"
                                    data-target="#scheduleContainer">
                                    Add Schedule +
                                </button>
                            </div>
                        @endcan
                    @endhasanyrole

                </div>
            </form>

            @can('view schedule')

                <div class="row">
                    <div class="col-12">

                        <!-- TEACHER TIMETABLE -->
                        @if (auth()->user()->hasRole('teacher'))
                            <h5 class="mb-3">My Schedule</h5>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">

                                    <thead class="table-dark">
                                        <tr>
                                            <th>Time</th>

                                            @foreach ($days as $day)
                                                <th>{{ $day }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($scheduleGrid as $row)
                                            <tr>
                                                <td>
                                                    {{ $row['time'] }}
                                                </td>

                                                @foreach ($days as $day)
                                                    <td style="min-width:150px">

                                                        @forelse ($row[$day] as $schedule)
                                                            <div class="p-2 mb-1 bg-light rounded">

                                                                <strong>
                                                                    {{ $schedule->subject->subject_name ?? '-' }}
                                                                </strong>
                                                                <br>

                                                                <small>
                                                                    Class {{ $schedule->class->class_name ?? '-' }}
                                                                </small>
                                                                <br>

                                                                <span class="text-muted">
                                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                                </span>

                                                            </div>
                                                        @empty
                                                            <span class="text-muted">-</span>
                                                        @endforelse

                                                    </td>
                                                @endforeach
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="{{ count($days) + 1 }}" class="text-muted py-4">
                                                        No schedule found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>

                                <!-- STUDENT TIMETABLE -->
                            @elseif(auth()->user()->hasRole('student'))
                                <h5 class="mb-3">Class Timetable</h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">

                                        <thead class="table-dark">
                                            <tr>
                                                <th>Time</th>

                                                @foreach ($days as $day)
                                                    <th>{{ $day }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($scheduleGrid as $row)
                                                <tr>
                                                    <td>
                                                        {{ $row['time'] }}
                                                    </td>

                                                    @foreach ($days as $day)
                                                        <td style="min-width:150px">

                                                            @forelse ($row[$day] as $schedule)
                                                                <div class="p-2 mb-1 bg-light rounded">

                                                                    <strong>
                                                                        {{ $schedule->subject->subject_name ?? '-' }}
                                                                    </strong>
                                                                    <br>

                                                                    <small>
                                                                        Teacher: {{ $schedule->teacher->name ?? '-' }}
                                                                    </small>
                                                                    <br>

                                                                    <span class="text-muted">
                                                                        Room {{ $schedule->class->class_name ?? '-' }}
                                                                    </span>

                                                                </div>
                                                            @empty
                                                                <span class="text-muted">-</span>
                                                            @endforelse

                                                        </td>
                                                    @endforeach
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="{{ count($days) + 1 }}" class="text-muted py-4">
                                                            No schedule found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                        </table>
                                    </div>

                                    <!-- ADMIN SCHEDULE LIST -->
                                @else
                                    <div class="card shadow-sm border-0">
                                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0 fw-bold text-primary">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                Schedule List
                                            </h5>
                                        </div>

                                        <div id="scheduleTable">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered align-middle text-center">

                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Day</th>
                                                            <th>Department</th>
                                                            <th>Subject , Room</th>
                                                            <th>Teacher</th>
                                                            <th>Time</th>
                                                            <th width="120">Actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse ($schedules as $schedule)
                                                            <tr>
                                                                <td>
                                                                    <span class="badge bg-light text-dark">
                                                                        {{ $schedule->day }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <span class="fw-semibold text-secondary">
                                                                        {{ $schedule->teacher->department->department_name ?? 'N/A' }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <div class="fw-semibold text-primary">
                                                                        {{ $schedule->subject->subject_name ?? 'N/A' }}

                                                                        <small class="text-muted">
                                                                            ({{ $schedule->class->class_name ?? 'N/A' }})
                                                                        </small>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <span class="fw-semibold">
                                                                        {{ $schedule->teacher->name ?? 'N/A' }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <span class="badge bg-success">
                                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    @can('view schedule')
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                                type="button" data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                Actions
                                                                            </button>

                                                                            <ul class="dropdown-menu shadow border-0">

                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('schedule.show', $schedule->id) }}">
                                                                                        <i class="fa fa-eye text-info me-2"></i>
                                                                                        View
                                                                                    </a>
                                                                                </li>

                                                                                @can('edit schedule')
                                                                                    <li>
                                                                                        <a class="dropdown-item btnedit" href="#"
                                                                                            data-id="{{ $schedule->id }}">
                                                                                            <i class="fa fa-edit text-warning me-2"></i>
                                                                                            Edit
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

                                                                                            <button type="submit"
                                                                                                class="dropdown-item text-danger"
                                                                                                onclick="return confirm('Delete this schedule?')">
                                                                                                <i class="fas fa-trash me-2"></i>
                                                                                                Delete
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
                                                                    <i class="fas fa-folder-open fa-2x mb-2"></i>
                                                                    <br>
                                                                    No schedules found
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>

                                                </table>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                                                <small class="text-muted">
                                                    Showing {{ $schedules->firstItem() ?? 0 }}
                                                    to {{ $schedules->lastItem() ?? 0 }}
                                                    of {{ $schedules->total() }} entries
                                                </small>

                                                {!! $schedules->links() !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                    @endcan

                </div>

                <!-- CREATE SCHEDULE MODAL -->
                @can('create schedule')
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
                                                <select name="department_id" id="department_id" class="form-control" required>
                                                    <option value="">Choose Department</option>

                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">
                                                            {{ $department->department_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Subject</label>
                                                <select name="subject_id" id="subject" class="form-control" required>
                                                    <option value="">-- Select Subject --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Teacher</label>
                                                <select name="teacher_id" id="teacher" class="form-control" required>
                                                    <option value="">-- Select Teacher --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Class</label>
                                                <select name="class_id" id="classes" class="form-control" required>
                                                    <option value="">-- Select Class --</option>

                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">
                                                            {{ $class->class_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Day</label>
                                                <select name="day" class="form-control" required>
                                                    <option value="">-- Select Day --</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Start Time</label>
                                                <input type="time" name="start_time" class="form-control" step="900"
                                                    required>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>End Time</label>
                                                <input type="time" name="end_time" class="form-control" step="900" required>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button type="submit" class="btn btn-primary">
                                            Save Schedule
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                @endcan

                <!-- EDIT SCHEDULE MODAL -->
                @hasanyrole('admin')
                    <div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">

                            <form id="editScheduleForm" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Edit Schedule</h5>

                                        <button type="button" class="close text-white" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label>Department</label>
                                                <select name="department_id" id="edit_department_id" class="form-control" required>
                                                    <option value="" selected hidden>Choose Department</option>

                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">
                                                            {{ $department->department_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Subject</label>
                                                <select name="subject_id" id="edit_subject" class="form-control" required>
                                                    <option value="" selected hidden>-- Select Subject --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Teacher</label>
                                                <select name="teacher_id" id="edit_teacher" class="form-control" required>
                                                    <option value="" selected hidden>-- Select Teacher --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Class</label>
                                                <select name="class_id" id="edit_classes" class="form-control" required>
                                                    <option value="" selected hidden>-- Select Class --</option>

                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">
                                                            {{ $class->class_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Day</label>
                                                <select name="day" id="edit_day" class="form-control" required>
                                                    <option value="" selected hidden>-- Select Day --</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Start Time</label>
                                                <input type="time" name="start_time" id="edit_start_time" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>End Time</label>
                                                <input type="time" name="end_time" id="edit_end_time" class="form-control"
                                                    required>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button type="submit" class="btn btn-warning">
                                            Update Schedule
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                @endhasanyrole

            </section>

        @endsection

        @section('scripts')
            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    function loadSubjectsAndTeachers(deptId, subjectSelector, teacherSelector, selectedSubject = null,
                        selectedTeacher = null) {
                        let $subject = $(subjectSelector);
                        let $teacher = $(teacherSelector);

                        $subject.empty().append('<option value="">Loading...</option>');
                        $teacher.empty().append('<option value="">Loading...</option>');

                        if (!deptId) {
                            $subject.empty().append('<option value="">-- Select Subject --</option>');
                            $teacher.empty().append('<option value="">-- Select Teacher --</option>');
                            return;
                        }

                        $.get('/get-subjects/' + deptId, function(data) {
                            $subject.empty().append('<option value="">-- Select Subject --</option>');

                            $.each(data, function(_, subject) {
                                let selected = selectedSubject == subject.id ? 'selected' : '';
                                $subject.append(
                                    `<option value="${subject.id}" ${selected}>${subject.subject_name}</option>`
                                );
                            });
                        });

                        $.get('/get-teachers/' + deptId, function(data) {
                            $teacher.empty().append('<option value="">-- Select Teacher --</option>');

                            $.each(data, function(_, teacher) {
                                let selected = selectedTeacher == teacher.id ? 'selected' : '';
                                $teacher.append(
                                    `<option value="${teacher.id}" ${selected}>${teacher.name}</option>`
                                );
                            });
                        });
                    }

                    $('#department_id').on('change', function() {
                        loadSubjectsAndTeachers(
                            $(this).val(),
                            '#subject',
                            '#teacher'
                        );
                    });

                    $('#edit_department_id').on('change', function() {
                        loadSubjectsAndTeachers(
                            $(this).val(),
                            '#edit_subject',
                            '#edit_teacher'
                        );
                    });

                    $(document).on('click', '.btnedit', function(e) {
                        e.preventDefault();

                        let id = $(this).data('id');

                        $.get('/schedule/' + id + '/edit', function(data) {

                            $('#editScheduleForm').attr('action', '/schedule/update/' + data.id);

                            $('#edit_department_id').val(data.department_id);

                            loadSubjectsAndTeachers(
                                data.department_id,
                                '#edit_subject',
                                '#edit_teacher',
                                data.subject_id,
                                data.teacher_id
                            );

                            $('#edit_classes').val(data.class_id);
                            $('#edit_day').val(data.day);

                            if (data.start_time) {
                                $('#edit_start_time').val(data.start_time.substring(0, 5));
                            }

                            if (data.end_time) {
                                $('#edit_end_time').val(data.end_time.substring(0, 5));
                            }

                            $('#editScheduleModal').modal('show');

                        }).fail(function(xhr) {
                            console.error(xhr.responseText);
                            alert('Error loading schedule');
                        });
                    });

                });
            </script>
        @endsection
