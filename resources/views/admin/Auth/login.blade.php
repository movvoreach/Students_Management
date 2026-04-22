<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>LMS Login</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
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
    <img src="data:image/jpeg;base64,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o+KmIYr9afSX6XL8tyeg3Rve+je9+1feGvFVFiNb9MfUvjOixui1jXDmbbkroiIIrhBgMFbSvpKgaTHtAvta4eK9u5wOarPF5xbR4TLJKyd83KMDCHtDbWdpXFir2sJZWtaXOIDQLknIAINOIVrIY3SvNg0d52AdJXNqG9ZVuqJvJxHlJNxePJxjoAt7ls4Q4xLXztp6cc2/MvsGoyv+Q/zVgwXCWENp484YjeVx+2l1kHf09HWgmMApzouneOfLY+zGPEHvv2qWREBERAREQEREBERAREQEREGMsYc0tcLgggg6iDrCqWM4U1reRmuYibwSDxoH7AT/AKuresJY2uaWuAIIsQdRCCg0WJzUkginsb+K4eTnGwtOx/QrnQVccrbsPWDrb1hQ2KYPoMLCzl6c62HN8XS06yB3qu/Q54PC0r3TxjVonw8Y3EeePeg6MGrKyp+EcNWu5souRrLRZw9phzCs1HiUMvk5Gu6L87tBzQetERAREQEXlrcQhhF5ZGs9ogE9Q1lVLGuMCNg0adukdQdJkL+q3W73ILbiGIRQMMkrg1o36ydwG0rnGNY7UYhL9Hp2kN1huwevKRq6v91oZh1ZWO5eqeYo/SlycRujZqAVqwXCBocnTtMMPnPPlJukX+OrrQeXAsGDAYIDdx/eZ/7rfkFcqWmZGwRsFmjV8ST0pS0zI2BkY0WjV+pO0rcgIiICIiAiIgIiICIiAiIgIiICIiAo2twdjzpsJik9Jm32m6j8VJIgp2LYLpZ1MHKW1S01w8dJAz+KgnYESb01S11vNqBouHRpD5rpy81VQQyeUja7pIFx1HWg5604vD4rZHD+HI2Udzl9PCfE25Ojl7YQfyhXR3B+HzHSM9h5t3OusfqV41VMvbolBSzwpxR2TY5OyH9Qtb5MZm1iVo9ZzYh/Krx9TSbamTssF9bwfj898r/afYfy2QUAcGH30qqpYzeI/CPP3iVPYRgMbM6anJP/ADaq/eAfkFbabDII82RtB32u7vOa9aCJpcEbfTndyz9lxZjepv6qWREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQf/2Q=="
         class="logo">

    <!-- TITLE -->
    <div class="title">
        សូមបញ្ចូលអ៊ីមែល និងពាក្យសម្ងាត់របស់អ្នក
    </div>

    <!-- ERROR -->
    @if(session('error'))
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
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your Gmail"
                       required>
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
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password"
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
