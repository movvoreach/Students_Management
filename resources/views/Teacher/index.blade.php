@extends('admin.layouts.master')

@section('title', 'Teacher Management')

@push('styles')
<style>
    #loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(240, 239, 239, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    #loading-overlay.active {
        display: flex !important;
    }

    .custom-input {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        margin-bottom: 15px;
    }

    .required {
        color: red;
    }
</style>
@endpush

@section('content')

<div id="loading-overlay">
    <div class="text-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
    </div>
</div>

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
            <div class="input-group">

                <div class="input-group-append">
                    <button class="btn btn-warning"><i class="fas fa-eraser"></i></button>
                </div>

                <input class="form-control form-control-lg custom-input" type="search"
                    placeholder="Search by name / subject / phone / email">

                <div class="input-group-append">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>

                <a href="{{ route('teachers.create') }}" class="ml-2">
                    <button class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Add Teacher
                    </button>
                </a>

            </div>
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

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Teacher Info</th>
                            <th>Subject</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th class="text-center">Photo</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">More</th>
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

                                <td>{{ $teacher->subject }}</td>

                                <td>{{ $teacher->gender }}</td>

                                <td>{{ $teacher->phone }}</td>

                                <td>{{ $teacher->email }}</td>

                                <td class="text-center">
                                    <img src="{{ $teacher->image ? asset('storage/' . $teacher->image) : 'https://via.placeholder.com/80' }}"
                                        class="img-thumbnail" style="height:45px;">
                                </td>

                                {{-- DELETE --}}
                                <td class="text-center">
                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this teacher?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                                {{-- EDIT --}}
                                <td class="text-center">
                                    <a href="{{ route('teachers.edit', $teacher->id) }}"
                                        class="btn btn-primary btn-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>

                                {{-- MORE --}}
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-xs" data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href=""
                                                class="dropdown-item">
                                                <i class="fas fa-eye mr-2"></i> View Profile
                                            </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    No teachers found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="card-footer bg-white border-top-0">
                <p class="small text-muted mb-0">Showing {{ count($teachers ?? []) }} teacher(s)</p>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {

    $('.btn-primary').click(function () {
        $('#loading-overlay').addClass('active');
        setTimeout(function () {
            $('#loading-overlay').removeClass('active');
        }, 800);
    });

});
</script>
@endpush
