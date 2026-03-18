@extends('admin.layouts.master')

@section('title', 'Course Create')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <style>
        .required {
            color: red;
            font-weight: bold;
        }

        .custom-input {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px 15px;
            transition: all 0.2s;
            margin-bottom: 15px;
        }

        .custom-input:focus {
            border-color: #4a67ff;
            box-shadow: 0 0 0 0.2rem rgba(74, 103, 255, 0.25);
            outline: none;
        }

        .thumbnail-preview {
            width: 240px;
            height: 150px;
            border: 2px dashed #ced4da;
            border-radius: 8px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.2s;
        }

        .thumbnail-preview:hover {
            border-color: #4a67ff;
            background: #eef1ff;
        }

        .thumbnail-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-preview span {
            color: #6c757d;
            text-align: center;
            font-size: 14px;
        }
    </style>
@endpush


@section('content')

<div class="row mt-4 shadow-sm">
    <div class="col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Create Book</h2>
            <hr>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Book List</a></li>
                    <li class="breadcrumb-item active">Create Book</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card bg-white shadow-sm">

    <div class="card-header">
        <h3 class="card-title">Book Information</h3>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        {{-- STATIC VERSION (no route, no csrf needed if demo) --}}

        <div class="card-body">
            <div class="row">

                <!-- Publisher -->
                <div class="col-md-6">
                    <label>Publisher <span class="text-danger">*</span></label>
                    <select class="form-control custom-input">
                        <option>-- Select Publisher --</option>
                        <option>ABC Publisher</option>
                        <option>Tech Books</option>
                        <option>Global Library</option>
                    </select>
                </div>

                <!-- ISBN -->
                <div class="col-md-6">
                    <label>ISBN <span class="text-danger">*</span></label>
                    <input type="text" class="form-control custom-input" placeholder="Enter ISBN">
                </div>

                <!-- Title -->
                <div class="col-md-6 mt-3">
                    <label>Book Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control custom-input" placeholder="Enter book title">
                </div>

                <!-- Author -->
                <div class="col-md-6 mt-3">
                    <label>Author</label>
                    <input type="text" class="form-control custom-input" placeholder="Enter author name">
                </div>

                <!-- Price -->
                <div class="col-md-6 mt-3">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" class="form-control custom-input" placeholder="0.00">
                </div>

                <!-- Stock -->
                <div class="col-md-6 mt-3">
                    <label>Stock Quantity</label>
                    <input type="number" class="form-control custom-input" placeholder="0">
                </div>

                <!-- Rack -->
                <div class="col-md-6 mt-3">
                    <label>Rack Number</label>
                    <input type="text" class="form-control custom-input" placeholder="A1, B2...">
                </div>

                <!-- Status -->
                <div class="col-md-6 mt-3">
                    <label>Status</label>
                    <select class="form-control custom-input">
                        <option>Available</option>
                        <option>Out of Stock</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="col-md-12 mt-3">
                    <label>Description</label>
                    <textarea class="form-control custom-input" rows="4"></textarea>
                </div>

                <!-- Image -->
                <div class="col-md-6 mt-4">
                    <label>Book Image</label>

                    <div class="thumbnail-preview" onclick="document.getElementById('image').click()">
                        <span id="previewText">
                            <i class="fas fa-image fa-2x"></i><br>
                            Click to upload
                        </span>
                        <img id="previewImg" style="display:none;">
                    </div>

                    <input type="file" id="image" class="d-none" accept="image/*">
                </div>

            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save"></i> Create Book
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewImg').style.display = 'block';
            document.getElementById('previewText').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
