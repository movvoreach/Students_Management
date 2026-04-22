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

                                            <a class="dropdown-item" href="#" data-toggle="modal"
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
                                        <small class="text-muted">Subject</small><br>
                                        <b>{{ $schedule->teacher->subject ?? 'N/A' }}</b>
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
            <!-- ===================================================== -->
            <!-- CREATE SCHEDULE MODAL -->
            <!-- ===================================================== -->
            <div class="modal fade" id="scheduleContainer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">

                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf

                        <div class="modal-content">

                            <!-- HEADER -->
                            <div class="modal-header">
                                <h5 class="modal-title">Create Schedule</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <!-- BODY -->
                            <div class="modal-body">
                                <div class="row">

                                    <!-- TEACHER -->
                                    <div class="col-md-6">
                                        <label>Teacher</label>
                                        <select name="teacher_id" class="form-control" required>
                                            <option value="">-- Select Teacher --</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- CLASS -->
                                    <div class="col-md-6">
                                        <label>Class</label>
                                        <select name="class_id" class="form-control" required>
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- DAY -->
                                    <div class="col-md-6 mt-2">
                                        <label>Day</label>
                                        <select name="day" class="form-control">
                                            <option>Monday</option>
                                            <option>Tuesday</option>
                                            <option>Wednesday</option>
                                            <option>Thursday</option>
                                            <option>Friday</option>
                                            <option>Saturday</option>
                                            <option>Sunday</option>
                                        </select>
                                    </div>

                                    <!-- TIME -->
                                    <div class="col-md-3 mt-2">
                                        <label>Start Time</label>
                                        <select name="start_time" class="form-control" required>
                                            <option value="">-- Select Start Time --</option>
                                            @for ($h = 7; $h <= 20; $h++)
                                                <option value="{{ sprintf('%02d:00', $h) }}">
                                                    {{ sprintf('%02d:00', $h) }}
                                                </option>
                                                <option value="{{ sprintf('%02d:30', $h) }}">
                                                    {{ sprintf('%02d:30', $h) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <label>End Time</label>
                                        <select name="end_time" class="form-control" required>
                                            <option value="">-- Select End Time --</option>
                                            @for ($h = 7; $h <= 20; $h++)
                                                <option value="{{ sprintf('%02d:00', $h) }}">
                                                    {{ sprintf('%02d:00', $h) }}
                                                </option>
                                                <option value="{{ sprintf('%02d:30', $h) }}">
                                                    {{ sprintf('%02d:30', $h) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <!-- FOOTER -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
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
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5>Enroll Student</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <input type="text" name="student_id" class="form-control"
                                        placeholder="Student ID" required>
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

            <!-- ===================================================== -->
            <!-- QR CODE MODAL (JOIN CLASS TEST) -->
            <!-- ===================================================== -->
            <div class="modal fade" id="qrModal" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">

                    <div class="modal-content text-center">

                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-qrcode"></i> Join Class
                            </h5>
                            <button class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <p>Scan to join class</p>

                            <!-- QR CODE -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=CLASS_280"
                                class="img-fluid">

                            <hr>

                            <small>Class ID: <b>280</b></small>

                        </div>

                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                                Close
                            </button>
                        </div>

                    </div>

                </div>
            </div>
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
        @endforeach

    });
</script>
