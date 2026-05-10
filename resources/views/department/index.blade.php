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
            <h1>Department Management</h1>
        </div>
    </section>

    {{-- SEARCH --}}
<<<<<<< HEAD
    <form method="GET" action="{{ route('departments.index') }}">

        <div class="row g-2 align-items-center">

            {{-- SEARCH --}}
            <div class="col-md-5">
                <div class="input-group">

                    <a href="{{ route('departments.index') }}" class="btn btn-warning">
                        <i class="fas fa-eraser"></i>
                    </a>

                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Search department name">

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>

                </div>
            </div>

            {{-- PER PAGE --}}
            <div class="col-md-2">
                <select name="per_page" class="form-control" onchange="this.form.submit()">

                    <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>

                </select>
            </div>

            {{-- TOTAL --}}
            <div class="col-md-3 text-end">
                <span class="text-muted">
                    Total: {{ $departments->total() }}
                </span>
            </div>

        </div>

    </form>
=======
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">

                <form method="GET" action="{{ route('departments.index') }}">

                    <div class="row g-2 align-items-center">

                        {{-- SEARCH --}}
                        <div class="col-md-5">
                            <div class="input-group">

                                <a href="{{ route('departments.index') }}" class="btn btn-warning">
                                    <i class="fas fa-eraser"></i>
                                </a>

                                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search department name">

                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>

                            </div>
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
                                Total: {{ $departments->total() }}
                            </span>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">
                &times;
            </button>

            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">
                &times;
            </button>

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- CLASS TABLE --}}
    <div class="col-12">

        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <h5 class="mb-0 me-2">Department List</h5>

                        <a href="{{ route('departments.create') }}" class="ml-2">
                            <button type="button" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Department
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
                                <th>Department Info</th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($departments as $key => $department)
                                <tr>

                                    {{-- NO --}}
                                    <td class="text-center">
                                        {{ $departments->firstItem() + $key }}
                                    </td>

                                    {{-- DEPARTMENT INFO --}}
                                    <td>
                                        <strong>{{ $department->department_name }}</strong>
                                        <div class="small text-muted">
                                            Department ID: DP00{{ $department->id }}
                                        </div>
                                    </td>



                                    {{-- ACTION --}}
                                    <td class="text-center">

                                        {{-- VIEW --}}
                                        <a href="{{ route('departments.show', $department->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('departments.edit', $department->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                            style="display:inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this department?')">

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
                                        No department found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- PAGINATION --}}
            <div class="card-footer d-flex justify-content-end">
                {{ $departments->appends(request()->all())->links('pagination::bootstrap-5') }}
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
