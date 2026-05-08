@extends('admin.layouts.master')

@section('title', 'Schedule Detail')

@section('content')

    <div class="container-fluid khmer-font">

        {{-- SCHEDULE INFO --}}
        <div class="card border-0 shadow-sm mb-4 mt-4">

            <div class="card-body p-4">

                {{-- TITLE SECTION --}}
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-dark mb-1">
                        {{ $schedule->class->class_name ?? 'N/A' }}
                    </h3>

                    <span class="text-muted">
                        {{ $schedule->subject->subject_name ?? 'Course Schedule Management (Ms-Word and Ms-Excel)' }}

                    </span>
                </div>

                <hr class="my-3">

                {{-- INFO GRID --}}
                <div class="row g-3 text-center">

                    {{-- Teacher --}}
                    <div class="col-md-3">
                        <div class="p-2">
                            <small class="text-muted d-block">Teacher</small>
                            <div class="fw-semibold text-dark">
                                {{ $schedule->teacher->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div class="col-md-3">
                        <div class="p-2">
                            <small class="text-muted d-block">Department</small>
                            <div class="fw-semibold text-dark">
                                {{ optional(optional($schedule->teacher)->department)->department_name ?? 'English' }}
                            </div>
                        </div>
                    </div>

                    {{-- Day --}}
                    <div class="col-md-3">
                        <div class="p-2">
                            <small class="text-muted d-block">Day</small>
                            <div class="fw-semibold text-dark">
                                {{ $schedule->day }}
                            </div>
                        </div>
                    </div>

                    {{-- Time --}}
                    <div class="col-md-3">
                        <div class="p-2">
                            <small class="text-muted d-block">Time</small>
                            <div class="fw-bold text-success">
                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                            </div>
                        </div>
                    </div>

                    {{-- Schedule Code --}}
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Schedule Code</small>
                            <div class="fw-semibold text-dark">
                                #{{ $schedule->id ?? '008' }}
                            </div>
                        </div>
                    </div>

                    {{-- Created Date --}}
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Created Date</small>
                            <div class="fw-semibold text-dark">
                                {{ optional($schedule->created_at)->format('d/m/Y') ?? '01/08/2024' }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- STUDENT LIST --}}
        <div class="card">

            <div class="card-header bg-white">

                <strong>Student List</strong>

                @hasanyrole('admin|teacher')
                    {{-- BUTTON OPEN MODAL — visible to admin and teacher only --}}
                    <a href="#" id="btnadd" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                        data-target="#enrollModal">
                        <i class="fas fa-plus"></i>
                    </a>
                @endhasanyrole


            </div>

            <div class="card-body">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Student Name</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($schedule->students as $key => $student)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>

                                <td>
                                    <strong>{{ $student->name }}</strong>
                                    <div class="text-muted small">{{ $student->gender }}</div>
                                </td>

                                <td>{{ $student->student_code }}</td>

                                <td><span class="badge badge-success">Active</span></td>

                                <td>{{ $student->created_at->format('d/m/Y') }}</td>

                                <td class="text-center">
                                    <a href="{{ route('student.show', $student->id) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('schedule.remove.student', [$schedule->id, $student->id]) }}"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Are you sure you want to remove this student from this schedule?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No students found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="card-footer">
                Total Students: {{ $schedule->students->count() }}
            </div>

        </div>

    </div>

    {{-- ===================== --}}
    {{-- ENROLL STUDENT MODAL --}}
    {{-- ===================== --}}
    <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('enrollment.store') }}" method="POST">
                @csrf
                {{-- IMPORTANT HIDDEN DATA --}}
                {{-- <input type="hidden" name="class_id" value="{{ $schedule->class->id ?? '' }}"> --}}
                <input id="schedule_id" type="hidden" name="schedule_id" value="{{ $schedule->id ?? '' }}">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Enroll Student</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">

                        <select class="js-example-basic-single" name="student_id">

                        </select>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Enroll
                        </button>

                    </div>

                </div>

            </form>
        </div>

    </div>

    </div>

@endsection
@push('scripts')
    <script>
        $(function() {

            $('#btnadd').on('click', function(e) {
                // console.log('Modal is fully shown');
                // $('#schedule_id').val('schedule_id');
                var sche = $('#schedule_id').val();
                // console.log(sche);
                $('.js-example-basic-single').empty();
                $.ajax({
                    url: "/check-student?" + $.param({
                        schedule_id: sche
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

        });
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endpush
