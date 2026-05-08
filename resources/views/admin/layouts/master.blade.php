<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard | LMS')</title>
    {{--
    <link rel="icon" type="image/png" href="{{ asset('backend/dist/img/spilogo.png') }}"> --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- ✅ Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&family=Battambang:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ✅ Font Awesome (must load BEFORE AdminLTE) --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

    {{-- ✅ AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

    {{-- Optional plugins --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Your page styles --}}
        <style>
        .khmer-font {
            font-family: 'Battambang', sans-serif !important;
        }

        /* CARD STYLE */
        .card {
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .card-body {
            padding: 25px;
        }

        /* TITLE */
        .schedule-title {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            color: #1f2d3d;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .schedule-subtitle {
            text-align: center;
            font-size: 14px;
            color: #7b8a97;
            margin-bottom: 10px;
        }

        /* INFO BOX */
        .info-box {
            padding: 15px 10px;
            transition: all 0.25s ease;
        }

        .info-box:hover {
            background: #f8f9ff;
            border-radius: 10px;
            transform: translateY(-2px);
        }

        .info-label {
            font-size: 12px;
            color: #9aa5b1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #2c3e50;
        }

        /* TIME HIGHLIGHT */
        .info-value.text-success {
            color: #1abc9c !important;
            font-weight: 700;
        }

        /* HORIZONTAL LINE */
        hr {
            border: none;
            height: 1px;
            background: linear-gradient(to right, transparent, #dfe6e9, transparent);
            margin: 15px 0 20px 0;
        }

        /* TABLE HEADER (if used later) */
        .table thead {
            background: linear-gradient(135deg, #eef2ff, #e9ecff);
        }

        /* BUTTON ACTION */
        .btn-action {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-action:hover {
            transform: scale(1.08);
        }

        /* RESPONSIVE IMPROVEMENT */
        @media (max-width: 768px) {
            .schedule-title {
                font-size: 20px;
            }

            .info-box {
                text-align: center;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('admin.partials.header')
        @include('admin.partials.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    @yield('page-title')
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    {{-- ✅ JS order: jQuery -> Bootstrap -> plugins -> AdminLTE --}}
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
