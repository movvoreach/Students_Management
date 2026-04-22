@extends('admin.layouts.master')

@section('title', 'Edit Student')

@push('styles')
<style>
    .required { color: red; font-weight: bold; }

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
    }

    .thumbnail-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail-preview span {
        color: #6c757d;
        font-size: 14px;
        text-align: center;
    }
</style>
@endpush


@section('content')

<div class="row mt-4 shadow-sm">
    <div class="col-12">
        <h2>Edit Student</h2>
        <hr>
    </div>
</div>


<div class="card shadow-sm">

    <div class="card-header">
        <h3 class="card-title">Update Student Information</h3>
    </div>

    <form action="{{ route('student.update', $student->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                {{-- STUDENT CODE --}}
                <div class="col-md-6">
                    <label>Student ID <span class="required">*</span></label>
                    <input type="text"
                           name="student_code"
                           value="{{ old('student_code', $student->student_code) }}"
                           class="form-control custom-input"
                           placeholder="STU-001">
                </div>

                {{-- NAME --}}
                <div class="col-md-6">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $student->name) }}"
                           class="form-control custom-input">
                </div>

                {{-- GENDER --}}
                <div class="col-md-6">
                    <label>Gender</label>
                    <select name="gender" class="form-control custom-input">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                {{-- DOB --}}
                <div class="col-md-6">
                    <label>Date of Birth</label>
                    <input type="date"
                           name="dob"
                           value="{{ old('dob', $student->dob) }}"
                           class="form-control custom-input">
                </div>

                {{-- CLASS --}}
                <div class="col-md-6">
                    <label>Class</label>
                    <input type="text"
                           name="class"
                           value="{{ old('class', $student->class) }}"
                           class="form-control custom-input">
                </div>

                {{-- PHONE --}}
                <div class="col-md-6">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $student->phone) }}"
                           class="form-control custom-input">
                </div>

                {{-- EMAIL --}}
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $student->email) }}"
                           class="form-control custom-input">
                </div>

                {{-- IMAGE --}}
                <div class="col-md-6">
                    <label>Student Photo</label>

                    <div class="thumbnail-preview"
                         onclick="document.getElementById('image').click()">

                        @if($student->image)
                            <img id="previewImg"
                                 src="{{ asset('storage/' . $student->image) }}">
                        @else
                            <span id="previewText">
                                Click to upload
                            </span>
                        @endif

                    </div>

                    <input type="file"
                           id="image"
                           name="image"
                           class="d-none"
                           accept="image/*">
                </div>

            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Student
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
            let img = document.getElementById('previewImg');

            if (!img) {
                document.querySelector('.thumbnail-preview').innerHTML =
                    '<img id="previewImg">';
                img = document.getElementById('previewImg');
            }

            img.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
</script>
@endpush
