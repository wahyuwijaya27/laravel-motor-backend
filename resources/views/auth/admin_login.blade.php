<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>Motor</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silakan login untuk melanjutkan</p>
                <form action="{{ route('admin.login.post') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="email_or_phone" class="form-control" placeholder="Email or Phone" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                    </div>
                </form>
                {{-- <div class="text-center mt-3">
                    <a href="{{ route('forgot-password.form') }}">Lupa Password?</a>
                </div> --}}
                {{-- <div class="text-center mt-3">
                    <a href="{{ route('admin.register') }}">Belum punya akun? Daftar di sini</a>
                </div> --}}
            </div>
        </div>
    </div>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
</body>
</html>
