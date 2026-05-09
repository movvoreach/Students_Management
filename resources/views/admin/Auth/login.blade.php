<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>LMS Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background: #f3f5fb;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Battambang', sans-serif;
        }

        .login-box {
            width: 420px;
            background: #fff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .logo {
            width: 90px;
            margin-bottom: 10px;
        }

        .title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
        }

        .btn-login {
            width: 100%;
            height: 45px;
            border-radius: 8px;
            background: #4e73df;
            color: white;
            font-weight: bold;
            border: none;
        }

        .btn-login:hover {
            background: #2e59d9;
        }

        .bottom-text {
            font-size: 13px;
            margin-top: 10px;
        }

        .forgot {
            float: right;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <!-- LOGO -->
        <img src="{{ asset('backend/dist/img/lms.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="width:80px; height:75px; margin-right:10px;">
        <!-- TITLE -->
        <div class="title">
            សូមបញ្ចូលអ៊ីមែល និងពាក្យសម្ងាត់របស់អ្នក
        </div>

        <!-- ERROR -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- EMAIL -->
            <div class="form-group text-left">
                <label>Gmail</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Enter your Gmail" required>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="form-group text-left">
                <label>Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password"
                        required>
                </div>
            </div>

            <!-- OPTIONS -->
            <div class="form-group text-left">
                <input type="checkbox"> Remember me

                <a href="#" class="forgot">
                    Forgot Password?
                </a>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-login">
                Login
            </button>

        </form>

    </div>

</body>

</html>
