@extends('admin.layouts.master')

@section('title', 'Book-shop Automation Software (BAS)')

@section('content')

<style>
    .content-wrapper,
    .content-wrapper h1,
    .content-wrapper h2,
    .content-wrapper h3,
    .content-wrapper h4,
    .content-wrapper h5,
    .content-wrapper h6,
    .content-wrapper p,
    .content-wrapper span,
    .content-wrapper a,
    .content-wrapper table,
    .content-wrapper th,
    .content-wrapper td,
    .breadcrumb {
        font-family: 'Battambang', sans-serif !important;
    }

    .content-wrapper h1,
    .content-wrapper .card-title {
        font-weight: 600;
    }

    .small-box .inner h3 {
        font-weight: 500;
    }
</style>

<section class="content mt-4">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Book-shop Automation Software (BAS)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Book-shop Automation Software (BAS)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card card-outline card-primary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-filter"></i> Filter Data</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: none;">
                            <form action="#" method="GET" id="filterForm">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Quick Date Range</label>
                                        <div class="btn-group btn-group-sm d-flex" role="group">
                                            <button type="button" class="btn btn-outline-primary">Today</button>
                                            <button type="button" class="btn btn-outline-primary">This Week</button>
                                            <button type="button" class="btn btn-outline-primary">This Month</button>
                                            <button type="button" class="btn btn-outline-primary">Last Month</button>
                                            <button type="button" class="btn btn-outline-primary">This Year</button>
                                            <button type="button" class="btn btn-outline-secondary">Clear</button>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control form-control-sm" placeholder="YYYY-MM-DD">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control form-control-sm" placeholder="YYYY-MM-DD">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Book Status</label>
                                            <select class="form-control form-control-sm">
                                                <option>All Status</option>
                                                <option>Available</option>
                                                <option>Out of Stock</option>
                                                <option>Requested</option>
                                                <option>Sold</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Book Category</label>
                                            <select class="form-control form-control-sm">
                                                <option>All Categories</option>
                                                <option>Programming</option>
                                                <option>Networking</option>
                                                <option>Database</option>
                                                <option>English</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> Apply Filter
                                        </button>
                                        <a href="#" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-redo"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Row 1 -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>120</h3>
                            <p>Total Books</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>95</h3>
                            <p>Available Books</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>35</h3>
                            <p>Total Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>$2,450</h3>
                            <p>Total Sales</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Row 2 -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-store"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Books Sold</span>
                            <span class="info-box-number">540</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-plus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">New Customers</span>
                            <span class="info-box-number">12</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Publishers</span>
                            <span class="info-box-number">8</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Month Revenue</span>
                            <span class="info-box-number">$1,250.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Tables -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-list mr-1"></i>
                                Recent Book Sales
                            </h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View All
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Book</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Mov Vo Reach</td>
                                        <td>Laravel 12 Guide</td>
                                        <td>Mar 10, 2026</td>
                                        <td><span class="badge badge-success">Sold</span></td>
                                    </tr>
                                    <tr>
                                        <td>Sok Dara</td>
                                        <td>Networking Basics</td>
                                        <td>Mar 12, 2026</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>Chanthy</td>
                                        <td>Flutter Development</td>
                                        <td>Mar 15, 2026</td>
                                        <td><span class="badge badge-info">Delivered</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-book-reader mr-1"></i>
                                Requested Books
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info">Latest Requests</span>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Author</th>
                                        <th>Request Count</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Advanced PHP</td>
                                        <td>John Smith</td>
                                        <td>5</td>
                                        <td><span class="badge badge-warning">Requested</span></td>
                                    </tr>
                                    <tr>
                                        <td>Cyber Security</td>
                                        <td>David Lee</td>
                                        <td>3</td>
                                        <td><span class="badge badge-danger">Out of Stock</span></td>
                                    </tr>
                                    <tr>
                                        <td>Database Design</td>
                                        <td>Maria Kim</td>
                                        <td>4</td>
                                        <td><span class="badge badge-success">Available</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart + Stats -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Sales Trend
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display:block;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Inventory Statistics
                            </h3>
                        </div>
                        <div class="card-body">

                            <div class="info-box mb-3 bg-info">
                                <span class="info-box-icon"><i class="fas fa-book-open"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Inventory</span>
                                    <span class="info-box-number">210</span>
                                </div>
                            </div>

                            <div class="info-box mb-3 bg-success">
                                <span class="info-box-icon"><i class="fas fa-certificate"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Books Sold</span>
                                    <span class="info-box-number">95</span>
                                </div>
                            </div>

                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Requests</span>
                                    <span class="info-box-number">12</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bolt mr-1"></i>
                                Quick Actions
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <a href="#" class="btn btn-app bg-primary">
                                        <i class="fas fa-plus"></i> Add Book
                                    </a>
                                </div>

                                <div class="col-md-3 col-6">
                                    <a href="#" class="btn btn-app bg-success">
                                        <i class="fas fa-user-plus"></i> Add Customer
                                    </a>
                                </div>

                                <div class="col-md-3 col-6">
                                    <a href="#" class="btn btn-app bg-info">
                                        <i class="fas fa-truck"></i> Publishers
                                    </a>
                                </div>

                                <div class="col-md-3 col-6">
                                    <a href="#" class="btn btn-app bg-warning">
                                        <i class="fas fa-chart-bar"></i> Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</section>

@endsection
