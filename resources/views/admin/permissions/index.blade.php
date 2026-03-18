@extends('admin.layouts.master')

@section('title', 'Permissions')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">

<style>
    .permission-name-badge{
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 6px;
        background: #6c757d;
        color: #fff;
        display: inline-block;
    }
</style>
@endpush

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions List</h3>

                    <div class="card-tools">
                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Permission
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th style="width: 110px" class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($permissions as $index => $permission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            <span class="permission-name-badge">
                                                {{ $permission->name }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $permission->description ?? '-' }}
                                        </td>

                                        <td class="text-center">
                                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No permissions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

                @if(method_exists($permissions, 'links'))
                    <div class="card-footer clearfix">
                        {{ $permissions->links() }}
                    </div>
                @endif

            </div>

        </div>
    </section>

@endsection
