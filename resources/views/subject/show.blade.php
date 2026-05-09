@extends('admin.layouts.master')

@section('title', 'Schedule Detail')

@section('content')

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

    <div class="container-fluid khmer-font">

        <div class="card shadow-sm mt-4">
            <div class="card-body">

                <h2 class="schedule-title">{{ $subject->department->department_name }}</h2>
                <p class="schedule-subtitle">Subject Name: {{ $subject->subject_name }}</p>
                <p class="schedule-subtitle">Department ID: {{ $subject->department->id }}</p>

                <hr>


            </div>


        </div>

    @endsection
