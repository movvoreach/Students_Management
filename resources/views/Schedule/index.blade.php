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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Schedule</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>

                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>

                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- STATS -->
            {{-- <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>5</h3>
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
                            <h3>4</h3>
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
                            <h3>22</h3>
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
                            <h3>1</h3>
                            <p>Inactive</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- TOP ACTION -->
            <!-- TOP ACTION -->
            <!-- TOP ACTION -->

            <!-- TOP ACTION with combined filter form -->
            <form method="GET" action="{{ route('schedule.index') }}" class="mb-3">
                <div class="row">
                    @role('admin')
                        <div class="col-md-3 mb-2"> {{-- Search input --}}
                            <input type="text" name="search" class="form-control" placeholder="Search Schedule..."
                                value="{{ request('search') }}">
                        </div>

                        {{-- @role('admin') --}}
                        <div class="col-md-2 mb-2"> {{-- Department filter --}}
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
                                    <option value="{{ $dayOption }}" {{ request('day') == $dayOption ? 'selected' : '' }}>
                                        {{ $dayOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endrole


                    @hasanyrole('admin')
                        <div class="col-md-2 mb-2"> {{-- Add Schedule button --}}
                            <button type="button" class="btn btn-primary w-100" data-toggle="modal"
                                data-target="#scheduleContainer">
                                Add Schedule +
                            </button>
                        </div>
                    @endhasanyrole
                </div>
            </form>
        </div>

        @can('view schedule')

            <div class="row">
                <div class="col-12">

                    @if (auth()->user()->hasRole('teacher'))
                        {{-- @php

                            @endphp --}}

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
                                    @foreach ($schedules as $scheduleRow)
                                        <tr>

                                            {{-- TIME --}}
                                            <td>
                                                {{ \Carbon\Carbon::parse($scheduleRow['time']['start_time'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($scheduleRow['time']['end_time'])->format('h:i A') }}
                                            </td>

                                            {{-- DAYS --}}
                                            @foreach ($days as $day)
                                                <td style="min-width:150px">

                                                    @forelse ($scheduleRow[$day] as $schedule)
                                                        <div class="p-2 mb-1 bg-light">

                                                            <strong>
                                                                {{ $schedule->subject->subject_name ?? '-' }}
                                                            </strong><br>

                                                            <small>
                                                                Class {{ $schedule->class->class_name ?? '-' }}
                                                            </small><br>

                                                            <span class="text-muted">
                                                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                                            </span>

                                                        </div>

                                                    @empty

                                                        <span class="text-muted">-</span>
                                                    @endforelse

                                                </td>
                                            @endforeach

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
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

<<<<<<< Updated upstream
                                <tbody>
                                    @foreach ($schedules as $scheduleRow)
                                        <tr>

                                            {{-- TIME --}}
                                            <td>
                                                {{ \Carbon\Carbon::parse($scheduleRow['time']['start_time'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($scheduleRow['time']['end_time'])->format('h:i A') }}
                                            </td>

                                            {{-- DAYS --}}
                                            @foreach ($days as $day)
                                                <td style="min-width:150px">

                                                    @forelse ($scheduleRow[$day] as $schedule)
                                                        <div class="p-2 mb-1 bg-light">

                                                            <strong>
                                                                {{ $schedule->subject->subject_name ?? '-' }}
                                                            </strong><br>

                                                            <small>
                                                                {{ $schedule->teacher->name ?? '-' }}
                                                            </small><br>

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
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                                {{-- <small class="text-muted">
=======
                                </table>
                                <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                                    {{-- <small class="text-muted">
>>>>>>> Stashed changes
                                        Showing {{ $schedules->firstItem() ?? 0 }} to {{ $schedules->lastItem() ?? 0 }}
                                        of {{ $schedules->total() }} entries
                                    </small> --}}

<<<<<<< Updated upstream
                                {{-- {!! $schedules->links() !!} --}}
                            </div>
                        </div>
                    @else
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-primary">
                                    <i class="fas fa-calendar-alt me-2"></i> Schedule List
                                </h5>
=======
                                    {{-- {!! $schedules->links() !!} --}}
                                </div>
>>>>>>> Stashed changes
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
                                            @forelse ($data as $schedule)
                                                <tr>

                                                    <!-- Day -->
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{ $schedule->day }}
                                                        </span>
                                                    </td>

                                                    <!-- Department -->
                                                    <td>
                                                        <span class="fw-semibold text-secondary">
                                                            {{ $schedule->teacher->department->department_name ?? 'N/A' }}
                                                        </span>
                                                    </td>

                                                    <!-- Subject + Class -->
                                                    <td>

                                                        <div class="fw-semibold text-primary">
                                                            {{ $schedule->subject->subject_name ?? 'N/A' }}

                                                            <small class="text-muted">
                                                                ({{ $schedule->class->class_name ?? 'N/A' }})
                                                            </small>
                                                        </div>

                                                    </td>

                                                    <!-- Teacher -->
                                                    <td>
                                                        <span class="fw-semibold">
                                                            {{ $schedule->teacher->name ?? 'N/A' }}
                                                        </span>
                                                    </td>

                                                    <!-- Time -->
                                                    <td>

                                                        <span class="badge bg-success">

                                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}

                                                        </span>

                                                    </td>

                                                    <!-- Actions -->
                                                    <td>

                                                        @can('view schedule')
                                                            <div class="dropdown">

                                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                    data-bs-toggle="dropdown">

                                                                    Actions

                                                                </button>

                                                                <ul class="dropdown-menu shadow border-0">

                                                                    {{-- VIEW --}}
                                                                    <li>

                                                                        <a class="dropdown-item"
                                                                            href="{{ route('schedule.show', $schedule->id) }}">

                                                                            <i class="fa fa-eye text-info me-2"></i>

                                                                            View

                                                                        </a>

                                                                    </li>

                                                                    {{-- EDIT --}}
                                                                    @can('edit schedule')
                                                                        <li>

                                                                            <a class="dropdown-item btnedit" href="#"
                                                                                data-id="{{ $schedule->id }}">

                                                                                <i class="fa fa-edit text-warning me-2"></i>

                                                                                Edit

                                                                            </a>

                                                                        </li>
                                                                    @endcan

                                                                    {{-- DELETE --}}
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

                                <!-- Pagination -->
                                @if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <div class="d-flex justify-content-between align-items-center mt-3 px-2">

                                        <small class="text-muted">
                                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
                                            of {{ $data->total() }} entries
                                        </small>

                                        {!! $data->links() !!}

                                    </div>
                                @endif

                            </div>

                        </div>
                    @endif

                </div>
            </div>

        @endcan


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
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value="">Choose Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}
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
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Day</label>
                                        <select name="day" class="form-control" required>
                                            <option value="">-- Select Day --</option>
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
                                        <input type="time" name="start_time" class="form-control" step="900">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control" step="900">
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
        @endcan

        <!-- EDIT SCHEDULE MODAL -->
        @hasanyrole('admin')
            <div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form id="editScheduleForm" method="POST">
                        @csrf
                        @method('PUT') {{-- Use PUT method for updates --}}

                        <div class="modal-content">
                            <!-- HEADER -->
                            <div class="modal-header bg-primary text-white"> {{-- Changed color for edit --}}
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
                                                <option value="{{ $department->id }}">{{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- SUBJECT -->
                                    <div class="col-md-6 mb-3">
                                        <label>Subject</label>
                                        <select name="subject_id" id="edit_subject" class="form-control" required>
                                            <option value="" selected hidden>-- Select Subject --</option>

                                        </select>
                                    </div>
                                    <!-- TEACHER -->
                                    <div class="col-md-6 mb-3">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="edit_teacher" class="form-control" required>
                                            <option value="" selected hidden>-- Select Teacher --</option>

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




        </div>
    </section>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {

        $(document).on('submit', '[id^="enrollForm"]', function() {
            let form = this;

            setTimeout(function() {
                form.reset();
                $(form).closest('.modal').modal('hide');
            }, 300);
        });

        // ==============================
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.select2-student').select2({
                dropdownParent: $(this),
                placeholder: "Search student...",
                width: '100%'
            });
        });

        $('.btnadd').on('click', function() {
            let scheduleId = $(this).data('id'); // FIXED

            let $select = $('.js-example-basic-single');
            $select.empty();

            $.ajax({
                url: "/check-student",
                method: "GET",
                data: {
                    schedule_id: scheduleId
                },
                dataType: "json",
                success: function(data) {
                    data.forEach(function(item) {
                        let option = new Option(item.text, item.id, false, false);
                        $select.append(option);
                    });
                    $select.trigger('change');
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });


        function loadSubjectsAndTeachers(deptId, subjectSelector, teacherSelector) {

            let $subject = $(subjectSelector);
            let $teacher = $(teacherSelector);

            $subject.empty().append('<option>Loading...</option>');
            $teacher.empty().append('<option>Loading...</option>');

            if (!deptId) return;

            // Subjects
            $.get('/get-subjects/' + deptId, function(data) {
                $subject.empty().append('<option value="">-- Select Subject --</option>');
                $.each(data, function(_, subject) {
                    $subject.append(
                        `<option value="${subject.id}">${subject.subject_name}</option>`);
                });
            });

            // Teachers
            $.get('/get-teachers/' + deptId, function(data) {
                $teacher.empty().append('<option value="">-- Select Teacher --</option>');
                $.each(data, function(_, teacher) {
                    $teacher.append(`<option value="${teacher.id}">${teacher.name}</option>`);
                });
            });
        }

        // ==============================
        $('#department_id').on('change', function() {
            loadSubjectsAndTeachers(
                $(this).val(),
                '#subject',
                '#teacher'
            );
        });


        $('.btnedit').on('click', function() {

            let id = $(this).data('id');

            $.get('/schedule/' + id + '/edit', function(data) {

                    $('#editScheduleForm').attr('action', '/schedule/update/' + data.id);

                    $('#edit_department_id')
                        .val(data.teacher.department_id)
                        .trigger('change');

                    setTimeout(function() {
                        $('#edit_subject').val(data.subject_id);
                        $('#edit_teacher').val(data.teacher_id);
                    }, 300);

                    // Other fields
                    $('#edit_classes').val(data.class_id);
                    $('#edit_day').val(data.day);
                    $('#edit_start_time').val(data.start_time.substring(0, 5));
                    $('#edit_end_time').val(data.end_time.substring(0, 5));

                    $('#editScheduleModal').modal('show');
                })
                .fail(function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error loading schedule');
                });
        });


        $('#edit_department_id').on('change', function() {
            loadSubjectsAndTeachers(
                $(this).val(),
                '#edit_subject',
                '#edit_teacher'
            );
        });

    });
</script>
