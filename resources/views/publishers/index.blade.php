@extends('admin.layouts.master')

@section('title', 'Publishers Management')

@push('styles')
<style>
    #loading-overlay {
        display: none;
        position: fixed;
        inset: 0;
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
        box-shadow: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .custom-input:focus {
        border-color: #4a67ff;
        box-shadow: 0 0 0 0.2rem rgba(74, 103, 255, 0.25);
        outline: none;
    }
</style>
@endpush

@section('content')

<div id="loading-overlay">
    <div class="text-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
    </div>
</div>

<section class="content-header mt-3">
    <div class="container-fluid">
        <h1>Publishers Management</h1>
    </div>
</section>

<div class="col-12">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix these errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<div class="col-12">
    <div class="card shadow-sm">

        <div class="card-header">
            <div class="float-left">
                Publisher List

                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addPublisherModal">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover">
                    <thead class="bg-primary-light">
                        <tr>
                            <th class="text-center" style="width: 80px;">No</th>
                            <th>Publisher Name</th>
                            <th class="text-center">Created Date</th>
                            <th class="text-center" style="width: 100px;">Delete</th>
                            <th class="text-center" style="width: 100px;">Edit</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- @forelse($publishers as $key => $publisher)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $publisher->name }}</td>
                                <td class="text-center">{{ $publisher->created_at->format('d M Y') }}</td>

                                <td class="text-center">
                                    <form action="{{ route('publishers.destroy', $publisher->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('publishers.edit', $publisher->id) }}" class="btn btn-primary btn-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No publishers found.</td>
                            </tr>
                        @endforelse --}}
                    </tbody>
                </table>

            </div>

            <div class="card-footer bg-white border-top-0">
                <p class="small text-muted mb-0">Showing  publishers</p>
            </div>

        </div>
    </div>
</div>

<!-- ADD PUBLISHER MODAL -->
<div class="modal fade" id="addPublisherModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('publishers.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">Add Publisher</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Publisher Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control custom-input" placeholder="Enter publisher name" required>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Publisher
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function () {
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            const form = this;

            if (confirm('Delete this publisher?')) {
                form.submit();
            }
        });
    });
</script>
@endpush
