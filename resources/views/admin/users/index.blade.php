@extends('admin.layouts.master')

@section('title','Manage Users')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')

{{-- Content Header --}}
<section class="content-header mt-4">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-users"></i> Manage Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    {{-- Stats Overview --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="info-box bg-gradient-primary">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">{{ $totalUsers ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-gradient-danger">
                <span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Admins</span>
                    <span class="info-box-number">{{ $admins ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-gradient-info">
                <span class="info-box-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Teachers</span>
                    <span class="info-box-number">{{ $teachers ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon"><i class="fas fa-user-graduate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Students</span>
                    <span class="info-box-number">{{ $students ?? 0 }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Staff row --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box bg-gradient-secondary">
                <span class="info-box-icon"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Staff</span>
                    <span class="info-box-number">{{ $staff ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">System Users</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="usersTable" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="120">Role</th>
                        <th width="180">Created At</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        @php
                            $role = $user->roles->first()?->name ?? 'No Role';
                            $map = [
                                'admin'   => 'badge-danger',
                                'teacher' => 'badge-primary',
                                'student' => 'badge-success',
                                'staff'   => 'badge-info',
                            ];
                            $badge = $map[strtolower($role)] ?? 'badge-secondary';
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge {{ $badge }}">{{ ucfirst($role) }}</span></td>
                            <td>{{ $user->created_at?->format('Y-m-d H:i') }}</td>

                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</section>
@endsection

@push('scripts')
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
$(function(){
    // ✅ Client-side DataTable (NO AJAX)
    $('#usersTable').DataTable({
        responsive: true,
        pageLength: 5
    });
});
</script>
@endpush
