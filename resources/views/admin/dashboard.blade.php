@extends('admin.layout') 

@section('content')
<div class="container-fluid">
    <!-- Header Dashboard -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <h1 class="display-4 text-center">Dashboard</h1>
            <p class="text-center">Selamat datang di dashboard admin!</p>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <!-- Card Total Motors -->
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Motors</h5>
                    <p class="card-text">{{ $totalMotors }}</p>
                </div>
            </div>
        </div>
        
        <!-- Card Total Users -->
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Announcements</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Maintenance server akan dilakukan pada tanggal 25 Desember 2024.</li>
                        <li>Penambahan fitur upload bukti pembayaran telah selesai.</li>
                        <li>Jangan lupa untuk memeriksa data checkout secara berkala.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips and Guides -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5>Tips for Managing the System</h5>
                </div>
                <div class="card-body">
                    <p>- Selalu periksa daftar pengguna baru untuk validasi.</p>
                    <p>- Pastikan semua checkout memiliki bukti pembayaran.</p>
                    <p>- Gunakan menu 'Manage Motors' untuk memperbarui daftar kendaraan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
        Logout
    </a>

</div>
@endsection
