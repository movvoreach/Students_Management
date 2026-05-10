@extends('admin.layouts.master')

@section('title', 'Create Department')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">

    <style>
        .required {
            color: red;
            font-weight: bold;
        }

        .custom-input {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px 15px;
            transition: all 0.2s;
            margin-bottom: 15px;
        }

        .custom-input:focus {
            border-color: #4a67ff;
            box-shadow: 0 0 0 0.2rem rgba(74, 103, 255, 0.25);
            outline: none;
        }
    </style>
@endpush

@section('content')

    <div class="row mt-4 shadow-sm">
        <div class="col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Create Department</h2>
                <hr>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Department List</a></li>
                        <li class="breadcrumb-item active">Create Department</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
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
    <div class="card bg-white shadow-sm">

        <div class="card-header">
            <h3 class="card-title">Subject Information</h3>
        </div>

        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="row">
                    <!-- Department Name -->
                    <div class="col-md-12">
                        <label>Department Name <span class="required">*</span></label>
                        <select name="department_id" class="form-control">
                            <option value="">Select Department</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Subject Name -->
                    <div class="col-md-6">
                        <label>Subject Name <span class="required">*</span></label>
                        <input type="text" name="subject_name" class="form-control custom-input" placeholder="Subject A">
                    </div>


                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Create Subject
                </button>
            </div>

        </form>

    </div>

@endsection
