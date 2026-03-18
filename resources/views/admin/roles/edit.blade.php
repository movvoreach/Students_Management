@extends('admin.layouts.master')

@section('title', 'Edit Role Permissions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

    <style>
        .role-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .role-icon {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .permission-category {
            background: #fff;
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .permission-item {
            padding: 8px;
            border-radius: 8px;
            transition: .2s;
        }

        .permission-item:hover {
            background: #f8f9fc;
        }

        .permission-item.selected {
            background: #eef2ff;
        }
    </style>
@endpush

@section('content')



        <section class="content-header mt-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-user-cog"></i> Edit Role Permissions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Edit {{ ucfirst($role->name) }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Role Header --}}
                    <div class="role-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="role-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h2 class="mb-1 text-capitalize">{{ $role->name }} Role</h2>
                                <p class="mb-0 opacity-75">
                                    Manage permissions assigned to this role
                                </p>
                            </div>
                            <div class="col-auto text-right">
                                <span style="font-size:36px;font-weight:bold" id="selectedCount">0</span>
                                <small>Permissions Selected</small>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="card mb-4">
                        <div class="card-body py-3 d-flex justify-content-between">

                            <div>
                                <button type="button" id="selectAll" class="btn btn-outline-primary mr-2">
                                    <i class="fas fa-check-double"></i> Select All
                                </button>

                                <button type="button" id="deselectAll" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Deselect All
                                </button>
                            </div>

                            <div>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-light mr-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- Group permissions by prefix --}}
                    @php
                        $grouped = $permissions->groupBy(function ($perm) {
                            return explode('.', $perm->name)[0];
                        });
                    @endphp

                    <div class="row">

                        @foreach ($grouped as $group => $perms)
                            <div class="col-md-6">
                                <div class="permission-category">

                                    <h5>
                                        <i class="fas fa-folder-open"></i>
                                        {{ ucfirst(str_replace('-', ' ', $group)) }}

                                        <span class="float-right">
                                            <button type="button" class="btn btn-sm btn-outline-primary select-category"
                                                data-category="{{ $group }}">
                                                <i class="fas fa-check"></i> All
                                            </button>
                                        </span>
                                    </h5>

                                    @foreach ($perms as $permission)
                                        @php
                                            $checked = in_array($permission->name, $rolePermissions ?? []);
                                        @endphp

                                        <div class="permission-item {{ $checked ? 'selected' : '' }}"
                                            data-category="{{ $group }}">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input permission-checkbox"
                                                    id="perm_{{ $permission->id }}" name="permissions[]"
                                                    value="{{ $permission->name }}" {{ $checked ? 'checked' : '' }}>

                                                <label for="perm_{{ $permission->id }}"
                                                    class="custom-control-label d-block">

                                                    <strong>{{ ucwords(str_replace('.', ' ', $permission->name)) }}</strong>

                                                    <small class="text-muted d-block">
                                                        Permission: {{ $permission->name }}
                                                    </small>

                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Bottom Submit --}}
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-light">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Save Permissions
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </section>


@endsection


@push('scripts')
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        $(function() {

            function updateCounter() {
                let count = $('.permission-checkbox:checked').length;
                $('#selectedCount').text(count);
            }

            updateCounter();

            $('.permission-checkbox').on('change', function() {
                $(this).closest('.permission-item').toggleClass('selected', this.checked);
                updateCounter();
            });

            $('#selectAll').click(function() {
                $('.permission-checkbox').prop('checked', true).trigger('change');
            });

            $('#deselectAll').click(function() {
                $('.permission-checkbox').prop('checked', false).trigger('change');
            });

            $('.select-category').click(function() {
                let category = $(this).data('category');
                $('.permission-item[data-category="' + category + '"] .permission-checkbox')
                    .prop('checked', true)
                    .trigger('change');
            });

        });
    </script>
@endpush
