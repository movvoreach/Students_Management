@extends('admin.layouts.master')

@section('title', 'Courses Management')

@push('styles')
    <style>
        /* --- LOADING OVERLAY STYLE --- */
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

        /* ---------------------------- */

        .custom-input {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            margin-bottom: 15px;
        }

        .custom-input:focus {
            border-color: #4a67ff;
            box-shadow: 0 0 0 0.2rem rgba(74, 103, 255, 0.25);
            outline: none;
        }

        .required {
            color: red;
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
        <h1>Books Management</h1>
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
                       placeholder="Search by title / ISBN / author ">

                <div class="input-group-append">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BOOK TABLE --}}
<div class="col-12">
    <div class="card shadow-sm">

        <div class="card-header">
            <div class="float-left">
                Book List
                <a href="/books/create">
                    <button class="btn btn-primary btn-xs">
                        <i class="fas fa-plus"></i>
                    </button>
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover">
                    <thead class="bg-primary-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Book</th>
                            <th>Author</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">More</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-center">1</td>

                            <td>
                                Laravel 12 Complete Guide
                                <div class="small text-muted">ISBN: 9781234567890</div>
                            </td>

                            <td>John Developer</td>

                            <td class="text-center">$25.00</td>

                            <td class="text-center">
                                <span class="badge badge-success">50</span>
                            </td>

                            <td class="text-center">
                                <img src="https://via.placeholder.com/80x45"
                                     class="img-thumbnail" style="height:45px;">
                            </td>

                            <td class="text-center">
                                <button class="btn btn-danger btn-xs">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-primary btn-xs">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-xs" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item">
                                            <i class="fas fa-eye mr-2"></i> View Details
                                        </button>

                                        <button class="dropdown-item">
                                            <i class="fas fa-box mr-2"></i> Stock History
                                        </button>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    </tbody>

                </table>

            </div>

            <div class="card-footer bg-white border-top-0">
                <p class="small text-muted mb-0">Showing 1 of 1 books</p>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function(){

        // Loading effect
        $('.btn-primary').click(function(){
            $('#loading-overlay').addClass('active');
            setTimeout(function(){
                $('#loading-overlay').removeClass('active');
            }, 1000);
        });

        // Delete confirm
        $('.btn-danger').click(function(){
            Swal.fire({
                title: 'Delete this book?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            });
        });

    });
</script>
@endpush
