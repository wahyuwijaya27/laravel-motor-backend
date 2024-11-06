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
    <div class="row">
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
        

        <!-- Card Pending Orders -->
        <div class="col-md-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h5>Pending Orders</h5>
                    <p class="card-text">10</p> <!-- contoh data jumlah order yang pending -->
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Recent Activity
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentActivities as $index => $activity)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $activity->user->name }}</td> <!-- Menampilkan nama user -->
                            <td>{{ $activity->action }}</td> <!-- Menampilkan deskripsi aksi -->
                            <td>{{ $activity->created_at->format('Y-m-d') }}</td> <!-- Menampilkan tanggal aktivitas -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
        Logout
    </a>

</div>
@endsection


