@extends('admin.layouts.master')

@section('title', 'Create Teacher')

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

        .thumbnail-preview {
            width: 240px;
            height: 150px;
            border: 2px dashed #ced4da;
            border-radius: 8px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.2s;
        }

        .thumbnail-preview:hover {
            border-color: #4a67ff;
            background: #eef1ff;
        }

        .thumbnail-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-preview span {
            color: #6c757d;
            text-align: center;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')

    <div class="row mt-4 shadow-sm">
        <div class="col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Create Teacher</h2>
                <hr>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Teacher List</a></li>
                        <li class="breadcrumb-item active">Create Teacher</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card bg-white shadow-sm">

        <div class="card-header">
            <h3 class="card-title">Teacher Information</h3>
        </div>

        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                <div class="row">

                    <!-- Teacher ID -->
                    <div class="col-md-6">
                        <label>Teacher ID <span class="required">*</span></label>
                        <input type="text" name="teacher_code" class="form-control custom-input" placeholder="TCH-001">
                    </div>

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control custom-input"
                            placeholder="Enter teacher name">
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label>Gender</label>
                        <select name="gender" class="form-control custom-input">
                            <option value="">-- Select Gender --</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control custom-input">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control custom-input" placeholder="012 345 678">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control custom-input"
                            placeholder="teacher@email.com">
                    </div>
                    <!-- Password -->
                    <div class="col-md-6">
                        <label>Password <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control custom-input"
                            placeholder="Enter password">
                    </div>
                    {{-- Department Name --}}
                    <div class="col-md-6">
                        <label for="departmentSelect">Department</label>
                        <select name="department" id="departmentSelect" class="form-control">
                            <option value="">Choose a department...</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Image -->
                    <div class="col-md-6 mt-3">
                        <label>Teacher Photo</label>

                        <div class="thumbnail-preview" onclick="document.getElementById('image').click()">
                            <span id="previewText">
                                <i class="fas fa-user fa-2x"></i><br>
                                Click to upload
                            </span>
                            <img id="previewImg" style="display:none;">
                        </div>

                        <input type="file" id="image" name="image" class="d-none" accept="image/*">
                    </div>

                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Create Teacher
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('previewImg').style.display = 'block';
                document.getElementById('previewText').style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
