@extends('admin.layouts.master')

@section('title', 'Edit Class')

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
                <h2 class="pageheader-title">Edit Subject</h2>
                <hr>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subject List</a></li>
                        <li class="breadcrumb-item active">Edit Subject</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card bg-white shadow-sm">

        <div class="card-header">
            <h3 class="card-title">Subject Information</h3>
        </div>

        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                     <!-- Department Name -->
                    <div class="col-md-12">
                        <label>Department Name <span class="required">*</span></label>
                         <select name="department_id" class="form-control custom-input">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ $subject->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Subject Name -->
                    <div class="col-md-12">
                        <label>Subject Name <span class="required">*</span></label>
                        <input type="text" name="subject_name" value="{{ $subject->subject_name }}"
                            class="form-control custom-input" placeholder="Subject A">
                    </div>



                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Update Subject
                </button>
            </div>

        </form>

    </div>

@endsection
