@extends('admin.layouts.master')

@section('title', 'Teacher Management')

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

        .action-btn-group .btn-action {
            margin: 2px;
            padding: 5px 8px;
            font-size: 13px;
        }
    </style>
@endpush

@section('content')

    {{-- HEADER --}}
    <section class="content-header mt-3">
        <div class="container-fluid">
            <h1>Teacher Management</h1>
        </div>
    </section>

    {{-- SEARCH --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('teachers.index') }}" method="GET">
                    <div class="input-group">

                        <!-- CLEAR BUTTON -->
                        <div class="input-group-append">
                            <a href="{{ route('teachers.index') }}" class="btn btn-warning">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>


                        <input class="form-control form-control-lg custom-input" type="search" name="search"
                            placeholder="Search by name / subject / phone / email">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>


                        <a href="{{ route('teachers.create') }}" class="ml-2">
                            <button type="button" class="btn btn-success btn-lg">
                                <i class="fas fa-plus"></i> Add Teacher
                            </button>
                        </a>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- TEACHER TABLE --}}
    <div class="col-12">
        <div class="card shadow-sm">

            <div class="card-header">
                <div class="float-left">
                    Teacher List
                </div>
            </div>
            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <!-- LEFT: TITLE + ADD -->
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <h5 class="mb-0 me-2">Teacher List</h5>

                        <a href="{{ route('teachers.create') }}" class="ml-2">
                            <button type="button" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Teacher
                            </button>
                        </a>
                    </div>

                    <form action="{{ route('teachers.index') }}" method="GET">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row g-2 align-items-center">

                                    <!-- Department -->
                                    <div class="col-md-4">
                                        <select class="form-control" name="department_id" onchange="this.form.submit()">
                                            <option value="">Select Department</option>
                                            {{-- Assuming $teachers is a collection of Teacher models with department relationship --}}
                                            @foreach ($teachers->unique('department_id') as $teacher)
                                                <option value="{{ $teacher->department_id }}"
                                                    {{ request('department_id') == $teacher->department_id ? 'selected' : '' }}>
                                                    {{ $teacher->department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <!-- GENDER -->
                                    <div class="col-md-4">
                                        <select class="form-control" name="gender" onchange="this.form.submit()">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>
                                                Male
                                            </option>
                                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                        </select>
                                    </div>

                                    <!-- PER PAGE -->
                                    <div class="col-md-2">
                                        <select class="form-control" name="per_page" onchange="this.form.submit()">
                                            <option value="">Per Page</option>
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5
                                            </option>
                                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20
                                            </option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                            </option>
                                        </select>
                                    </div>

                                    <!-- TOTAL -->
                                    <div class="col-md-2 text-end">
                                        <span class="text-muted">
                                            Total: {{ $teachers->total() }}
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Teacher Info</th>
                                <th>Department</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th class="text-center">Photo</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($teachers as $key => $teacher)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>

                                    <td>
                                        <strong>{{ $teacher->name }}</strong>
                                        <div class="small text-muted">ID: {{ $teacher->teacher_code }}</div>
                                        <div class="small text-muted">DOB: {{ $teacher->dob }}</div>
                                    </td>

                                    <td>{{ $teacher->department->department_name ?? 'No Department' }}</td>

                                    <td>{{ $teacher->gender }}</td>

                                    <td>{{ $teacher->phone }}</td>

                                    <td>{{ $teacher->email }}</td>

                                    <td class="text-center">
                                        <img src="{{ $teacher->image ? asset('storage/' . $teacher->image) : asset('storage/teachers/default.png') }}"
                                            class="img-thumbnail" style="height:45px;">
                                    </td>

                                    <td class="text-center">

                                        <div class="action-btn-group">

                                            {{-- VIEW --}}
                                            <a href="{{ route('teachers.show', $teacher->id) }}"
                                                class="btn btn-info btn-action" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                class="btn btn-primary btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this teacher?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-action" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No teachers found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="card-footer d-flex justify-content-end">
                    {{ $teachers->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>

@endsection
