@extends('admin.layout') 

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Dashboard -->
    <div class="text-center mb-4">
        <h1 class="display-4">Dashboard Admin</h1>
        <p class="lead">Selamat datang di dashboard admin!</p>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <!-- Card Total Motors -->
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow mb-4 h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-auto">
                        <div>
                            <h5 class="card-title">Total Motors</h5>
                            <h3>{{ $totalMotors }}</h3>
                        </div>
                        <i class="bi bi-motorcycle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Card Total Users -->
        <div class="col-md-4">
            <div class="card text-white bg-success shadow mb-4 h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-auto">
                        <div>
                            <h5 class="card-title">Total Users</h5>
                            <h3>{{ $totalUsers }}</h3>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Laporan Pendapatan -->
        <div class="col-md-4">
            <div class="card bg-info text-white shadow mb-4 h-100">
                <div class="card-body text-center d-flex flex-column">
                    <h5 class="card-title mb-3">Laporan Pendapatan</h5>
                    <a href="{{ route('reports.index') }}" class="btn btn-light text-info fw-bold mt-auto">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="text-center mt-4">
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button class="btn btn-danger px-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>
</div>
@endsection
