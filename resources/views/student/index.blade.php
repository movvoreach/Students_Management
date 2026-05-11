@extends('admin.layouts.master')

@section('title', 'Student Management')

@push('styles')
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
@endpush

@section('content')



    {{-- HEADER --}}
    <section class="content-header mt-3">
        <div class="container-fluid">
            <h1>Student Management</h1>
        </div>
    </section>

    {{-- SEARCH --}}

    <div class="col-12">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="GET" action="{{ route('student.index') }}">

                        <div class="input-group">

                            {{-- CLEAR --}}
                            <a href="{{ route('student.index') }}" class="btn btn-warning">
                                <i class="fas fa-eraser"></i>
                            </a>

                            {{-- SEARCH INPUT --}}
                            <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                                class="form-control" placeholder="Search student / Name / ID /">

                            {{-- KEEP PER PAGE --}}
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">

                            {{-- BUTTON --}}
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="col-12">

        {{-- ================= TABLE CARD ================= --}}
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    {{-- LEFT: TITLE + ADD --}}
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <h5 class="mb-0 me-2">Student List</h5>

                        <a href="{{ route('student.create') }}" class="ml-2">
                            <button type="button" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Student
                            </button>
                        </a>
                    </div>
                    <form method="GET" action="{{ route('student.index') }}">
                        <div class="card shadow-sm">
                            <div class="card-body">

                                <div class="row g-2 align-items-center">

                                    {{-- SEARCH --}}
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <a href="{{ route('student.index') }}" class="btn btn-warning">
                                                <i class="fas fa-eraser"></i>
                                            </a>

                                            <input type="text" id="searchInput" name="search"
                                                value="{{ request('search') }}" class="form-control"
                                                placeholder="Search student...">

                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <select class="form-control" name="department_id" onchange="this.form.submit()">
                                            <option value="">Select Department</option>
                                            {{-- Assuming $students is a collection of Student models with department relationship --}}
                                            @foreach ($students->unique('department_id') as $student)
                                                <option value="{{ $student->department_id }}"
                                                    {{ request('department_id') == $student->department_id ? 'selected' : '' }}>
                                                    {{ $student->department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    {{-- GENDER --}}
                                    <div class="col-md-2">
                                        <select name="gender" class="form-control" onchange="this.form.submit()">
                                            <option value="">All Gender</option>
                                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>

                                    {{-- PER PAGE --}}
                                    <div class="col-md-2">
                                        <select name="per_page" class="form-control" onchange="this.form.submit()">
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5
                                            </option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20
                                            </option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                            </option>
                                        </select>
                                    </div>

                                    {{-- TOTAL --}}
                                    <div class="col-md-2 text-end">
                                        <span class="text-muted">
                                            Total: {{ $students->total() }}
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Student Info</th>
                                <th>Department</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($students as $key => $student)
                                <tr>

                                    {{-- NO --}}
                                    <td class="text-center">
                                        {{ $students->firstItem() + $key }}
                                    </td>

                                    {{-- STUDENT INFO --}}
                                    <td>
                                        <strong>{{ $student->name }}</strong>
                                        <div class="small text-muted">ID: {{ $student->student_code }}</div>
                                        <div class="small text-muted">DOB: {{ $student->dob }}</div>
                                    </td>

                                    {{-- CLASSES (ALL) --}}
                                    <td>
                                        {{ $student->department->department_name }}
                                        {{-- @forelse ($student->schedules as $schedule)
                                -
                                <span >
                                    {{ $schedule->class->class_name ?? 'No Class' }}
                                </span>

                                @empty
                                <span class="text-muted">No Class</span>
                                @endforelse --}}
                                    </td>

                                    {{-- GENDER --}}
                                    <td>{{ $student->gender }}</td>

                                    {{-- PHONE --}}
                                    <td>{{ $student->phone }}</td>

                                    {{-- EMAIL --}}
                                    <td>{{ $student->email }}</td>

                                    {{-- IMAGE --}}
                                    <td class="text-center">
                                        <img src="{{ $student->image ? asset('storage/' . $student->image) : asset('storage/students/default.png') }}"
                                            class="img-thumbnail" style="height:45px; width:45px; object-fit:cover;">
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="text-center">

                                        {{-- <a href="{{ route('schedule.student.detail', $student->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}

                                        </a>

                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('student.destroy', $student->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this student?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No students found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- PAGINATION --}

            </div>

        </div>

        {{-- PAGINATION --}}
                    <div class="card-footer d-flex justify-content-end">
                        {{ $students->appends(request()->all())->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>

        @endsection

        @push('scripts')
            <script>
                $(document).ready(function() {

                    // Loading effect
                    $('.btn-primary').on('click', function() {
                        $('#loading-overlay').addClass('active');

                        setTimeout(() => {
                            $('#loading-overlay').removeClass('active');
                        }, 800);
                    });

                    let searchValue = "{{ request('search') }}";

                    if (searchValue !== "") {
                        let input = document.getElementById("searchInput");

                        if (input) {
                            input.focus();
                            input.setSelectionRange(input.value.length, input.value.length);
                        }
                    }

                });
            </script>
        @endpush
