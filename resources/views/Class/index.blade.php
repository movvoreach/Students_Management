@extends('admin.layouts.master')

@section('title', 'Class Management')

@push('styles')
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(240, 239, 239, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        #loading-overlay.active {
            display: flex !important;
        }

        .custom-input {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            margin-bottom: 15px;
        }
    </style>
@endpush

@section('content')

    <div id="loading-overlay">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
        </div>
    </div>

    {{-- HEADER --}}
    <section class="content-header mt-3">
        <div class="container-fluid">
            <h1>Class Management</h1>
        </div>
    </section>

    {{-- SEARCH --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="input-group">

                    <div class="input-group-append">
                        <button class="btn btn-warning"><i class="fas fa-eraser"></i></button>
                    </div>

                    <input class="form-control form-control-lg custom-input" type="search"
                        placeholder="Search by class / campus / time">

                    <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>

                    <a href="/classes/create" class="ml-2">
                        <button class="btn btn-success btn-lg">
                            <i class="fas fa-plus"></i> Add Class
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>

    {{-- CLASS TABLE --}}
    <div class="col-12">
        <div class="card shadow-sm">

            <div class="card-header">
                <div class="float-left">
                    Class List
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Class Info</th>
                                <th>Table</th>
                                <th>Status</th>
                                <th class="text-center">Delete</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">More</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($classes as $key => $class)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>

                                    <td>
                                        <strong>{{ $class->class_name }}</strong>
                                        <div class="small text-muted">Class ID: CL00{{ $class->id }}</div>
                                    </td>

                                    <td>{{ $class->table }}</td>

                                    <td>
                                        @if ($class->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- DELETE --}}
                                    <td class="text-center">
                                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this class?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- EDIT --}}
                                    <td class="text-center">
                                        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-primary btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>

                                    {{-- MORE --}}
                                    <td class="text-center">
                                        <a href="{{ route('classes.show', $class->id) }}" class="btn btn-info btn-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        No class found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {

            $('.btn-primary').click(function() {
                $('#loading-overlay').addClass('active');
                setTimeout(function() {
                    $('#loading-overlay').removeClass('active');
                }, 800);
            });

        });
    </script>
@endpush
