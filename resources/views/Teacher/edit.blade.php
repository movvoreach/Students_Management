@extends('admin.layouts.master')

@section('title', 'Edit Teacher')

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
            <h2 class="pageheader-title">Edit Teacher</h2>
            <hr>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Teacher List</a></li>
                    <li class="breadcrumb-item active">Edit Teacher</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card bg-white shadow-sm">

    <div class="card-header">
        <h3 class="card-title">Teacher Information</h3>
    </div>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                <!-- Teacher ID -->
                <div class="col-md-6">
                    <label>Teacher ID <span class="required">*</span></label>
                    <input type="text" name="teacher_code" class="form-control custom-input"
                        value="{{ $teacher->teacher_code }}">
                </div>

                <!-- Full Name -->
                <div class="col-md-6">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control custom-input"
                        value="{{ $teacher->name }}">
                </div>

                <!-- Gender -->
                <div class="col-md-6">
                    <label>Gender</label>
                    <select name="gender" class="form-control custom-input">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ $teacher->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $teacher->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Date of Birth -->
                <div class="col-md-6">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control custom-input"
                        value="{{ $teacher->dob }}">
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control custom-input"
                        value="{{ $teacher->phone }}">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control custom-input"
                        value="{{ $teacher->email }}">
                </div>

                <!-- Password (optional update) -->
                <div class="col-md-6">
                    <label>Password <span class="text-muted">(leave blank to keep old)</span></label>
                    <input type="password" name="password" class="form-control custom-input"
                        placeholder="New password">
                </div>

                <!-- Subject -->
                <div class="col-md-6">
                    <label>Subject</label>
                    <input type="text" name="subject" class="form-control custom-input"
                        value="{{ $teacher->subject }}">
                </div>

                <!-- Image -->
                <div class="col-md-6 mt-3">
                    <label>Teacher Photo</label>

                    <div class="thumbnail-preview" onclick="document.getElementById('image').click()">

                        <span id="previewText" style="{{ $teacher->image ? 'display:none;' : '' }}">
                            <i class="fas fa-user fa-2x"></i><br>
                            Click to upload
                        </span>

                        <img id="previewImg"
                            src="{{ $teacher->image ? asset('storage/' . $teacher->image) : '' }}"
                            style="{{ $teacher->image ? '' : 'display:none;' }}">
                    </div>

                    <input type="file" id="image" name="image" class="d-none" accept="image/*">
                </div>

            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save"></i> Update Teacher
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
