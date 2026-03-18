@extends('admin.layouts.master')

@section('title', 'Permission Create')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">

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

    .hint-box{
        border:1px solid #e6e6e6;
        border-radius:10px;
        padding:12px;
        background:#fafafa;
    }

    .badge-soft{
        background:#eef1ff;
        color:#2e306f;
        border:1px solid rgba(46,48,111,.15);
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        display:inline-block;
        margin:2px 4px 0 0;
    }
</style>
@endpush

@section('content')

<div class="row mt-4 shadow-sm">
    <div class="col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Create Permission</h2>
            <hr>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions List</a></li>
                    <li class="breadcrumb-item active">Create Permission</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card bg-white shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Permission Information</h3>

        <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf

        <div class="card-body">
            <div class="row">

                {{-- Permission Name --}}
                <div class="col-md-6">
                    <label>Permission Name <span class="required">*</span></label>
                    <input type="text"
                           name="name"
                           id="permissionName"
                           value="{{ old('name') }}"
                           class="form-control custom-input"
                           placeholder="Example: students.view"
                           required>

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <small class="text-muted d-block mt-1">
                        Recommended format: <span class="badge-soft">module.action</span>
                        Example: <span class="badge-soft">students.view</span>
                        <span class="badge-soft">courses.create</span>
                        <span class="badge-soft">roles.delete</span>
                    </small>
                </div>

                {{-- Tips --}}
                <div class="col-md-6">
                    <div class="hint-box mt-4 mt-md-0">
                        <div class="font-weight-bold mb-2" style="color:#2e306f;">
                            Tips
                        </div>
                        <div class="text-muted" style="line-height:1.8">
                            ✅ Use lower case<br>
                            ✅ Use dot format: <b>module.action</b><br>
                            ✅ Keep names consistent across project<br>
                            ✅ Example modules: students, teachers, courses, lessons, roles, permissions
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save"></i> Create Permission
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>

<script>
    $(function () {

        // ✅ Auto-format permission name while typing:
        // "Students View" -> "students.view"
        $('#permissionName').on('input', function () {
            let v = $(this).val();

            // normalize spaces/underscores to dots
            v = v.replace(/_/g, '.');
            v = v.replace(/\s+/g, '.');

            // remove duplicate dots
            v = v.replace(/\.{2,}/g, '.');

            // remove invalid characters (keep letters, numbers, dot, dash)
            v = v.replace(/[^a-zA-Z0-9\.\-]/g, '');

            // lowercase
            v = v.toLowerCase();

            $(this).val(v);
        });

    });
</script>
@endpush
