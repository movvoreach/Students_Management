@extends('admin.layouts.master')

@section('title', 'Class Management')

@push('styles')
    <style>
        .content-wrapper,
        .content-wrapper h1,
        .content-wrapper h2,
        .content-wrapper h3,
        .content-wrapper p,
        .content-wrapper span,
        .content-wrapper table,
        .content-wrapper th,
        .content-wrapper td {
            font-family: 'Battambang', sans-serif !important;
        }

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

                <form method="GET" action="{{ route('classes.index') }}">

                    <div class="row g-2 align-items-center">

                        {{-- SEARCH --}}
                        <div class="col-md-5">
                            <div class="input-group">

                                <a href="{{ route('classes.index') }}" class="btn btn-warning">
                                    <i class="fas fa-eraser"></i>
                                </a>

                                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search class name">

                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>

                            </div>
                        </div>

                        {{-- STATUS FILTER --}}
                        <div class="col-md-2">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        {{-- PER PAGE --}}
                        <div class="col-md-2">
                            <select name="per_page" class="form-control" onchange="this.form.submit()">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>

                        {{-- TOTAL --}}
                        <div class="col-md-3 text-end">
                            <span class="text-muted">
                                Total: {{ $classes->total() }}
                            </span>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- CLASS TABLE --}}
    <div class="col-12">

        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <h5 class="mb-0 me-2">Class List</h5>

                        <a href="{{ route('classes.create') }}" class="ml-2">
                            <button type="button" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Class
                            </button>
                        </a>
                    </div>

                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Class Info</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($classes as $key => $class)
                                <tr>

                                    {{-- NO --}}
                                    <td class="text-center">
                                        {{ $classes->firstItem() + $key }}
                                    </td>

                                    {{-- CLASS INFO --}}
                                    <td>
                                        <strong>{{ $class->class_name }}</strong>
                                        <div class="small text-muted">
                                            Class ID: CL00{{ $class->id }}
                                        </div>
                                    </td>

                                    {{-- TABLE --}}
                                    <td>{{ $class->table }}</td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if ($class->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="text-center">

                                        {{-- VIEW --}}
                                        <a href="{{ route('classes.show', $class->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                            style="display:inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this class?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No class found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- PAGINATION --}}
            <div class="card-footer d-flex justify-content-end">
                {{ $classes->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Loading effect
            $('.btn-primary').on('click', function() {
                $('#loading-overlay').addClass('active');

                setTimeout(() => {
                    $('#loading-overlay').removeClass('active');
                }, 800);
            });

            // Keep cursor in search box
            let searchValue = "{{ request('search') }}";

            if (searchValue !== "") {
                let input = document.getElementById("searchInput");

                if (input) {
                    input.focus();
                    input.setSelectionRange(input.value.length, input.value.length);
                }
            }

        });
    </script>
@endpush
