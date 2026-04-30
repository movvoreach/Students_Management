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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- STATS (KEEP SAME OR OPTIONAL) -->
            <div class="row">

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

            </div>

            <!-- TOP ACTION -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Search Schedule...">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-secondary w-100">
                        Refresh
                    </button>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100" data-toggle="modal" data-target="#scheduleContainer">
                        Add Schedule +
                    </button>
                </div>
            </div>
            @can('view schedule')
            <!-- CLASS CARDS GRID -->
            <div class="row">

                @foreach ($schedules as $schedule)
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">

                            <div class="card-body">

                                <!-- HEADER -->
                                <div class="d-flex justify-content-between align-items-start">

                                    <div>
                                        <h5 class="mb-1 font-weight-bold">
                                            <i class="fas fa-home text-primary"></i>
                                            {{ $schedule->class->class_name ?? 'N/A' }}
                                        </h5>

                                        <small class="text-muted">
                                            Class ID:
                                            <span class="badge badge-primary">
                                                {{ $schedule->class->id ?? '-' }}
                                            </span>
                                        </small>
                                    </div>

                                    <!-- DROPDOWN -->
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="text-dark">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">

                                            <a class="btnadd" class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#enrollModal{{ $schedule->id }}">
                                                <i class="fas fa-user-plus text-primary"></i> Enroll Student
                                            </a>

                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#qrModal{{ $schedule->id }}">
                                                <i class="fas fa-qrcode text-success"></i> Show QR Code
                                            </a>

                                            <div class="dropdown-divider"></div>

                                            <form action="{{ route('schedule.delete', $schedule->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Do you want to delete this schedule?')">
                                                    <i class="fas fa-trash"></i> Delete Class
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <!-- CLASS INFO -->
                                <div class="row">

                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Teacher</small><br>
                                        <b>{{ $schedule->teacher->name ?? 'N/A' }}</b>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Status</small><br>
                                        <span class="badge badge-success">
                                            Active
                                        </span>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Day</small><br>
                                        <b>{{ $schedule->day }}</b>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Time</small><br>
                                        <span class="text-success font-weight-bold">
                                            {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        </span>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Department</small><br>
                                        <b>{{ optional(optional($schedule->teacher)->department)->department_name ?? 'English' }}</b>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Students</small><br>

                                        <b>
                                            {{ $schedule->students_count }}
                                            /
                                            {{ $schedule->class->table ?? 'N/A' }}
                                        </b>
                                    </div>

                                </div>

                                <hr>

                                <a href="{{ route('schedule.viewClass', $schedule->id) }}"
                                    class="btn btn-outline-primary btn-block">
                                    View Class
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            @endcan
            <!-- CREATE SCHEDULE MODAL -->
            <div class="modal fade" id="scheduleContainer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">

                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf

                        <div class="modal-content">

                            <!-- HEADER -->
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Create Schedule</h5>
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
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value="">Choose Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- SUBJECT -->
                                    <div class="col-md-6 mb-3">
                                        <label>Subject</label>
                                        <select name="subject_id" id="subject" class="form-control" required>
                                            <option value="">-- Select Subject --</option>
                                        </select>
                                    </div>

                                    <!-- TEACHER -->
                                    <div class="col-md-6 mb-3">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="teacher" class="form-control" required>
                                            <option value="">-- Select Teacher --</option>

                                        </select>
                                    </div>

                                    <!-- CLASS -->
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

                                    <!-- DAY -->
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

                                    <!-- START TIME -->
                                    <div class="col-md-3 mb-3">
                                        <label>Start Time</label>
                                        <input type="time" name="start_time" class="form-control" required>
                                    </div>

                                    <!-- END TIME -->
                                    <div class="col-md-3 mb-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control" required>
                                    </div>

                                </div>
                            </div>

                            <!-- FOOTER -->
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

            <!-- ===================================================== -->
            <!-- ENROLL STUDENT MODAL -->
            @foreach ($schedules as $schedule)
                <!-- 🔥 FIX: MODAL MUST BE HERE (INSIDE LOOP) -->
                <div class="modal fade" id="enrollModal{{ $schedule->id }}" tabindex="-1" role="dialog">

                    <div class="modal-dialog">

                        <form action="{{ route('enrollment.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="class_id" value="{{ $schedule->class->id }}">
                            <input class="schedule_id" type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5>Enroll Student</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <select name="student_id" class="form-control select2-student js-example-basic-single"
                                        required>
                                        <option value="" disabled selected>Select Student</option>



                                    </select>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button class="btn btn-primary">
                                        Enroll
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            @endforeach


    </section>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {

        @foreach ($schedules as $schedule)

            $('#enrollForm{{ $schedule->id }}').on('submit', function() {
                let form = this;

                setTimeout(function() {

                    // reset input
                    form.reset();

                    // close modal
                    $('#enrollModal{{ $schedule->id }}').modal('hide');

                }, 300);

            });


            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.select2-student').select2({
                    dropdownParent: $(this),
                    placeholder: "Search student...",
                    width: '100%'
                });
            });
            $('')
        @endforeach
        $('.btnadd').on('click', function() {

            var scheduleId = $('.schedule_id').val();

            console.log('Clicked Enroll for Schedule ID: ' + scheduleId);
            $('.js-example-basic-single').empty();
            $.ajax({
                url: "/check-student?" + $.param({
                    schedule_id: scheduleId
                }), // The server endpoint
                method: "GET", // Request type
                dataType: "json", // Expected data format
                success: function(response) {
                    console.log("done");
                    var data = response;
                    console.log(response);

                    // Loop through the array to add options
                    data.forEach(function(item) {
                        var newOption = new Option(item.text, item.id, false,
                            false);
                        $('.js-example-basic-single').append(newOption).trigger(
                            'change');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error); // Code to handle request failure
                }
            });

        });
        $('#department_id').on('change', function() {
            //  alert('hey');
            let deptId = $(this).val();
            // alert(deptId)
            $('#subject').empty();

            $.ajax({
                url: '/get-subjects/' + deptId,
                method: 'GET',
                success: function(data) {
                    $('#subject').append('<option>Select Subject</option>');
                    $.each(data, function(key, subject) {
                        $('#subject').append('<option value="' + subject.id + '">' +
                            subject.subject_name + '</option>');
                    });
                }

            });
        });
        $('#department_id').change(function() {
            var department_id = $(this).val();
            $('#teacher').empty(); // Clear teachers

            $.ajax({
                url: '/get-teachers/' + department_id,
                type: 'GET',
                success: function(data) {
                    $('#teacher').append('<option>Select Teacher</option>');
                    $.each(data, function(key, value) {
                        $('#teacher').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });


    });
</script>
