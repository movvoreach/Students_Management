@extends('admin.layouts.master')

@section('title', 'Schedule Management System')

@section('content')

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
    </style>

    <section class="content mt-4">

        <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <h1 class="m-0 fw-bold">My Profile</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
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
        <!-- Main Content -->
        <div class="container-fluid">

            @php
                $user = auth()->user();

                $profileImage = asset('backend/dist/img/user2-160x160.jpg');

                if ($user->student && $user->student->image) {
                    $profileImage = asset('storage/' . $user->student->image);
                    // dd($user->student->image);
                } elseif ($user->teacher && $user->teacher->image) {
                    $profileImage = asset('storage/' . $user->teacher->image);
                }
            @endphp

            <div class="row">

                <!-- Profile Card -->
                <div class="col-md-4">

                    <div class="card card-primary card-outline">

                        <div class="card-body box-profile text-center">

                            <div class="mb-3">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $profileImage }}"
                                    alt="User profile picture" style="width:120px; height:120px; object-fit:cover;">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ $user->name }}
                            </h3>

                            <p class="text-muted text-center">
                                {{ $user->email }}
                            </p>

                            <span class="badge badge-success px-3 py-2">
                                {{ $user->roles->first()->name ?? 'User' }}
                            </span>

                        </div>

                    </div>

                </div>

                <!-- User Information -->
                <div class="col-md-8">

                    @php
                        $user = auth()->user();

                        $profileImage = asset('backend/dist/img/user2-160x160.jpg');

                        if ($user->student && $user->student->image) {
                            $profileImage = asset('storage/' . $user->student->image);
                        } elseif ($user->teacher && $user->teacher->image) {
                            $profileImage = asset('storage/' . $user->teacher->image);
                        } else {
                            $profileImage = $user->image
                                ? asset('storage/' . $user->image)
                                : asset('backend/dist/img/user2-160x160.jpg');
                        }
                    @endphp

                    <div class="card card-primary card-outline card-outline-tabs">

                        <!-- Tabs -->
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="profile-tabs" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profile-info"
                                        role="tab">
                                        <i class="fas fa-user"></i>
                                        Profile Information
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="account-tab" data-toggle="pill" href="#account-info"
                                        role="tab">
                                        <i class="fas fa-cog"></i>
                                        Account Settings
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="password-tab" data-toggle="pill" href="#change-password"
                                        role="tab">
                                        <i class="fas fa-lock"></i>
                                        Change Password
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">

                            <div class="tab-content" id="profile-tabs-content">

                                <!-- Profile Information -->
                                <div class="tab-pane fade show active" id="profile-info" role="tabpanel">

                                    <div class="row">

                                        <!-- Left Side -->


                                        <!-- Right Side -->
                                        <div class="col-md-8">

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>Full Name</strong>
                                                </div>

                                                <div class="col-md-8">
                                                    {{ $user->name }}
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>Email Address</strong>
                                                </div>

                                                <div class="col-md-8">
                                                    {{ $user->email }}
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>Role</strong>
                                                </div>

                                                <div class="col-md-8">
                                                    {{ $user->roles->first()->name ?? 'User' }}
                                                </div>
                                            </div>

                                            <hr>

                                            @if ($user->student)
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>Student ID</strong>
                                                    </div>

                                                    <div class="col-md-8">
                                                        {{ $user->student->id }}
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>Phone</strong>
                                                    </div>

                                                    <div class="col-md-8">
                                                        {{ $user->student->phone ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <hr>
                                            @endif

                                            @if ($user->teacher)
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>Teacher Code</strong>
                                                    </div>

                                                    <div class="col-md-8">
                                                        {{ $user->teacher->teacher_code }}
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>Phone</strong>
                                                    </div>

                                                    <div class="col-md-8">
                                                        {{ $user->teacher->phone ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <hr>
                                            @endif


                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>Account Created</strong>
                                                </div>

                                                <div class="col-md-8">
                                                    {{ $user->created_at->format('d M Y') }}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Account Settings -->
                                <div class="tab-pane fade" id="account-info" role="tabpanel">

                                    <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label>Full Name</label>

                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ old('name', $user->name) }}">
                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label>Email Address</label>

                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email', $user->email) }}">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label>Profile Image</label>

                                            <input type="file" name="image" class="form-control">
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            Update Profile
                                        </button>

                                    </form>

                                </div>

                                <!-- Change Password -->
                                <div class="tab-pane fade" id="change-password" role="tabpanel">

                                    <form action="{{ route('profile.password.update') }}" method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label>Current Password</label>

                                            <input type="password" name="current_password" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>New Password</label>

                                            <input type="password" name="new_password" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm Password</label>

                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>

                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-key"></i>
                                            Change Password
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
