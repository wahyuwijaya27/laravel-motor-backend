<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Lupa</b>Password</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masukkan nomor WhatsApp Anda</p>
                <form action="{{ route('forgot-password.send-otp') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Nomor WhatsApp" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Kirim OTP</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
