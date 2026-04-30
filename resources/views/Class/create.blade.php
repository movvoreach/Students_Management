@extends('admin.layouts.master')

@section('title', 'Create Class')

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
                <h2 class="pageheader-title">Create Class</h2>
                <hr>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Class List</a></li>
                        <li class="breadcrumb-item active">Create Class</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card bg-white shadow-sm">

        <div class="card-header">
            <h3 class="card-title">Class Information</h3>
        </div>

        <form action="{{ route('classes.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="row">

                    <!-- Class Name -->
                    <div class="col-md-6">
                        <label>Class Name <span class="required">*</span></label>
                        <input type="text" name="class_name" class="form-control custom-input" placeholder="Class A">
                    </div>

                    <!-- Table -->
                    <div class="col-md-6">
                        <label>Capacity <span class="required">*</span></label>
                        <input type="text" name="table" class="form-control custom-input" placeholder="Table 1">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control custom-input">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Create Class
                </button>
            </div>

        </form>

    </div>

@endsection
