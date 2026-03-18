@extends('admin.layouts.master')

@section('title', 'Roles & Permissions')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
<style>
    .role-card { border-radius: 12px; overflow: hidden; }
    .role-icon{
        width: 50px; height: 50px;
        border-radius: 12px;
        display:flex; align-items:center; justify-content:center;
        font-size: 20px;
    }
    .permission-badge{
        display:inline-block;
        background:#f1f3f5;
        border:1px solid #e9ecef;
        color:#343a40;
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        margin: 3px 4px 0 0;
        white-space: nowrap;
    }
    .permission-badge.bg-secondary{ border-color:transparent; }
    .permission-category{
        border:1px solid #eee;
        border-radius:12px;
        padding:12px;
        margin-bottom:12px;
        background:#fff;
    }
    .permission-category h6{
        font-weight:700;
        margin-bottom:10px;
        color:#2e306f;
    }
</style>
@endpush

@section('content')



    {{-- Content Header --}}
    <section class="content-header mt-4">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user-shield"></i> Roles &amp; Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Roles &amp; Permissions</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Role
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- Main content --}}
    <section class="content">
        <div class="container-fluid">

            {{-- Stats Overview --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-box bg-gradient-primary">
                        <span class="info-box-icon"><i class="fas fa-users-cog"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Roles</span>
                            <span class="info-box-number">{{ isset($roles) ? $roles->count() : 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-key"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Permissions</span>
                            <span class="info-box-number">{{ isset($permissions) ? $permissions->count() : 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="fas fa-user-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Users Assigned</span>
                            <span class="info-box-number">{{ $usersAssigned ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Role Cards --}}
            <div class="row">
                @forelse($roles as $role)

                    @php
                        // choose color by role name (optional)
                        $name = strtolower($role->name);
                        $iconBg = 'bg-secondary';
                        $badgeClass = 'badge-secondary';

                        if(str_contains($name,'admin')) { $iconBg='bg-danger'; $badgeClass='badge-danger'; }
                        elseif(str_contains($name,'staff')) { $iconBg='bg-info'; $badgeClass='badge-info'; }
                        elseif(str_contains($name,'guest')) { $iconBg='bg-success'; $badgeClass='badge-success'; }

                        $permCount = $role->permissions->count();
                        $previewPerms = $role->permissions->pluck('name')->take(8);
                        $moreCount = max(0, $permCount - 8);

                        // users count (if relation exists). if not, show 0
                        $usersCount = $role->users_count ?? ($role->users?->count() ?? 0);
                    @endphp

                    <div class="col-md-4">
                        <div class="card role-card">
                            <div class="card-header bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="role-icon {{ $iconBg }} text-white mr-3">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0 text-capitalize">{{ $role->name }}</h4>
                                        <small class="text-muted">
                                            Role for system access control
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">
                                        <i class="fas fa-key"></i> {{ $permCount }} Permissions
                                    </span>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $usersCount }} Users
                                    </span>
                                </div>

                                <div class="permissions-preview" style="max-height:150px; overflow-y:auto;">
                                    @if($permCount == 0)
                                        <span class="text-muted">No permissions</span>
                                    @else
                                        @foreach($previewPerms as $p)
                                            <span class="permission-badge">
                                                <i class="fas fa-check text-success"></i> {{ $p }}
                                            </span>
                                        @endforeach

                                        @if($moreCount > 0)
                                            <span class="permission-badge bg-secondary text-white">
                                                +{{ $moreCount }} more
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer bg-light">
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> Manage Permissions
                                </a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">
                            No roles found.
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-plus"></i> Create New Role
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- All Permissions Reference --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list"></i> All Available Permissions</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @php
                        // Group permissions by prefix before dot (ex: bookings.create -> bookings)
                        $grouped = collect($permissions ?? [])->groupBy(function($p){
                            $name = is_object($p) ? $p->name : $p;
                            return explode('.', $name)[0] ?? 'other';
                        });
                    @endphp

                    <div class="row">
                        @foreach($grouped as $group => $perms)
                            <div class="col-md-6">
                                <div class="permission-category">
                                    <h6><i class="fas fa-folder-open"></i> {{ ucfirst($group) }}</h6>

                                    @foreach($perms as $perm)
                                        @php $permName = is_object($perm) ? $perm->name : $perm; @endphp
                                        <span class="permission-badge">
                                            <i class="fas fa-key text-warning"></i> {{ $permName }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- Role Comparison Matrix (simple auto table) --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Role Comparison Matrix</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    @php
                        $roleList = $roles ?? collect();
                        $permList = $permissions ?? collect();

                        // Build map: roleId => permission names array
                        $rolePermMap = [];
                        foreach($roleList as $r){
                            $rolePermMap[$r->id] = $r->permissions->pluck('name')->toArray();
                        }
                    @endphp

                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                @foreach($roleList as $r)
                                    @php
                                        $n = strtolower($r->name);
                                        $badge = 'badge-secondary';
                                        if(str_contains($n,'admin')) $badge='badge-danger';
                                        elseif(str_contains($n,'staff')) $badge='badge-info';
                                        elseif(str_contains($n,'guest')) $badge='badge-success';
                                    @endphp
                                    <th class="text-center">
                                        <span class="badge {{ $badge }} px-3 py-2 text-capitalize">
                                            {{ $r->name }}
                                        </span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permList as $perm)
                                @php $permName = is_object($perm) ? $perm->name : $perm; @endphp
                                <tr>
                                    <td><strong>{{ $permName }}</strong></td>

                                    @foreach($roleList as $r)
                                        @php
                                            $has = in_array($permName, $rolePermMap[$r->id] ?? []);
                                        @endphp
                                        <td class="text-center">
                                            @if($has)
                                                <i class="fas fa-check-circle text-success fa-lg"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger fa-lg"></i>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

@endsection
