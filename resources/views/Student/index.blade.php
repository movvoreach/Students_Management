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
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="input-group">

                    <div class="input-group-append">
                        <button class="btn btn-warning"><i class="fas fa-eraser"></i></button>
                    </div>

                    <input class="form-control form-control-lg custom-input" type="search"
                        placeholder="Search by name / class / phone / email">

                    <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>

                    <a href="{{ route('student.create') }}" class="ml-2">
                        <button class="btn btn-success btn-lg">
                            <i class="fas fa-plus"></i> Add Student
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>

    {{-- STUDENT TABLE --}}
    <div class="col-12">
        <div class="card shadow-sm">

            <div class="card-header">
                <div class="float-left">
                    Student List
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Student Info</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th class="text-center">Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($students as $key => $student)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>

                                    <td>
                                        <strong>{{ $student->name }}</strong>
                                        <div class="small text-muted">ID: {{ $student->student_code }}</div>
                                        <div class="small text-muted">DOB: {{ $student->dob }}</div>
                                    </td>

                                    <td>{{ $student->class }}</td>

                                    <td>{{ $student->gender }}</td>

                                    <td>{{ $student->phone }}</td>

                                    <td>{{ $student->email }}</td>

                                    <td class="text-center">
                                        <img src="{{ $student->image ? asset('storage/' . $student->image) : 'https://via.placeholder.com/80' }}"
                                            class="img-thumbnail" style="height:45px;">
                                    </td>


                                    <td class="text-center">

                                        <div class="action-btn-group">

                                            {{-- VIEW --}}
                                            <a href="#" class="btn btn-info btn-action" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('student.edit', $student->id) }}"
                                                class="btn btn-primary btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('student.destroy', $student->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this student?')">

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
                                    <td colspan="10" class="text-center text-muted">
                                        No students found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="card-footer bg-white border-top-0">
                    <p class="small text-muted mb-0">Showing 1 student</p>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {

            // Loading effect
            $('.btn-primary').click(function() {
                $('#loading-overlay').addClass('active');
                setTimeout(function() {
                    $('#loading-overlay').removeClass('active');
                }, 800);
            });

            // Delete confirm
            $('.btn-danger').click(function() {
                Swal.fire({
                    title: 'Delete this student?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete'
                });
            });

        });
    </script>
@endpush
