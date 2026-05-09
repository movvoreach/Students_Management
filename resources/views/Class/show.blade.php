@extends('admin.layouts.master')

@section('title', 'Schedule Detail')

@section('content')

    <style>
        .khmer-font {
            font-family: 'Battambang', sans-serif !important;
        }

        /* CARD STYLE */
        .card {
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .card-body {
            padding: 25px;
        }

        /* TITLE */
        .schedule-title {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            color: #1f2d3d;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .schedule-subtitle {
            text-align: center;
            font-size: 14px;
            color: #7b8a97;
            margin-bottom: 10px;
        }

        /* INFO BOX */
        .info-box {
            padding: 15px 10px;
            transition: all 0.25s ease;
        }

        .info-box:hover {
            background: #f8f9ff;
            border-radius: 10px;
            transform: translateY(-2px);
        }

        .info-label {
            font-size: 12px;
            color: #9aa5b1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #2c3e50;
        }

        /* TIME HIGHLIGHT */
        .info-value.text-success {
            color: #1abc9c !important;
            font-weight: 700;
        }

        /* HORIZONTAL LINE */
        hr {
            border: none;
            height: 1px;
            background: linear-gradient(to right, transparent, #dfe6e9, transparent);
            margin: 15px 0 20px 0;
        }

        /* TABLE HEADER (if used later) */
        .table thead {
            background: linear-gradient(135deg, #eef2ff, #e9ecff);
        }

        /* BUTTON ACTION */
        .btn-action {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-action:hover {
            transform: scale(1.08);
        }

        /* RESPONSIVE IMPROVEMENT */
        @media (max-width: 768px) {
            .schedule-title {
                font-size: 20px;
            }

            .info-box {
                text-align: center;
            }
        }
    </style>

    <div class="container-fluid khmer-font">

        {{-- SCHEDULE INFO --}}
        <div class="card border-0 shadow-sm mb-4 mt-4">

            <div class="card-body p-4">

                {{-- TITLE SECTION --}}
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-dark mb-1">
                        {{ $class->class_name }}
                    </h3>

                    <span class="text-muted">
                        {{ $class->id }}
                    </span>
                </div>

                <hr class="my-3">

                {{-- INFO GRID --}}
                <div class="row g-3 text-center">

                    {{-- Teacher --}}
                    <div class="col-md-3">
                        <div class="p-2">
                            <small class="text-muted d-block">Table Number</small>
                            <div class="fw-semibold text-dark">
                                {{ $class->table }}
                            </div>
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div class="col-md-3">
                        <div class="p-2">
                            <small class="text-muted d-block">Status</small>
                            <div class="fw-semibold text-dark">
                                <p>
                                    @if ($class->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- STUDENT LIST --}}
        <div class="card">

            <div class="card-header bg-white">

                <strong>Schedule List</strong>

                {{-- BUTTON OPEN MODAL --}}
                {{-- <a href="#" id="btnadd" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                    data-target="#enrollModal">
                    <i class="fas fa-plus"></i>
                </a> --}}

            </div>

            <div class="card-body">

                <table class="table table-bordered table-hover">


                    <thead>
                        <tr class="text-center">
                            <th class="text-center" width="50">#</th>
                            <th>Schedule</th>
                            <th>Day</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scheduleInClass as $key => $item)
                            <tr class="text-center">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->start_time }} - {{ $item->end_time }}</td> <!-- Adjust column names -->
                                <td>{{ $item->day }}</td>
                                <td>
                                    <!-- Action Buttons -->
                                    <a href="{{ route('schedule.show', $item->id) }}" class="btn btn-sm btn-primary">
                                        View
                                    </a>

                                </td>
                            </tr>
                        @endforeach

                </table>

            </div>
            {{--
            <div class="card-footer">
                Total Students: {{ $students->count() }}
            </div> --}}

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
