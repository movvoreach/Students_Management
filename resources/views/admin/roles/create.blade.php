@extends('admin.layouts.master')

@section('title', 'Create Role')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<style>
.role-header {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}
.role-icon {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    background: #eef1ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #2e306f;
}
.permission-category {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background: #fff;
}
.permission-item {
    padding: 8px;
    border-radius: 6px;
}
.permission-item.selected {
    background: #f4f6ff;
}
</style>
@endpush

@section('content')


    <!-- Page Header -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-plus-circle"></i> Create New Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item active">Create Role</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <!-- Basic Info -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i> Role Information
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Role Name *</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label>Description</label>
                                <input type="text"
                                       name="description"
                                       class="form-control"
                                       value="{{ old('description') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Preview -->
                <div class="role-header">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="role-icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h2 id="roleNamePreview">New Role</h2>
                            <p id="roleDescPreview" class="text-muted">
                                Set permissions for this role
                            </p>
                        </div>
                        <div class="col-auto text-right">
                            <span id="selectedCount"
                                  style="font-size:32px;font-weight:bold;">0</span>
                            <small>Permissions Selected</small>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <button type="button"
                                    id="selectAll"
                                    class="btn btn-outline-primary">
                                Select All
                            </button>

                            <button type="button"
                                    id="deselectAll"
                                    class="btn btn-outline-secondary">
                                Deselect All
                            </button>
                        </div>

                        <div>
                            <a href="{{ route('admin.roles.index') }}"
                               class="btn btn-light">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="btn btn-success">
                                Create Role
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Permission Categories -->
                <div class="row">
                    @foreach($permissionCategories as $category => $permissions)
                        <div class="col-md-6">
                            <div class="permission-category">
                                <h5>{{ $category }}</h5>

                                @foreach($permissions as $permission)
                                    <div class="permission-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   class="custom-control-input permission-checkbox"
                                                   id="perm_{{ $permission->id }}"
                                                   name="permissions[]"
                                                   value="{{ $permission->id }}">

                                            <label class="custom-control-label"
                                                   for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>

            </form>
        </div>
    </section>


@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const count = document.getElementById('selectedCount');

    function updateCount() {
        count.textContent =
            document.querySelectorAll('.permission-checkbox:checked').length;
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    document.getElementById('selectAll').addEventListener('click', () => {
        checkboxes.forEach(cb => cb.checked = true);
        updateCount();
    });

    document.getElementById('deselectAll').addEventListener('click', () => {
        checkboxes.forEach(cb => cb.checked = false);
        updateCount();
    });

});
</script>
@endpush
