<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN ADMIN</title>
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('adminlte/fontawesome/css/all.min.css') }}">
    <style>
        /* Pastikan wrapper dan sidebar memiliki tinggi penuh */
        html, body, .wrapper {
            height: 100%;
            margin: 0;
        }
        .main-sidebar {
            height: 100vh; /* Tinggi penuh layar */
            position: fixed; /* Tetap di posisi saat scroll */
            top: 0; /* Mulai dari atas */
            left: 0; /* Mulai dari sisi kiri */
            z-index: 1030; /* Pastikan berada di atas elemen lain */
        }
        .content-wrapper {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            min-height: 100vh; /* Pastikan konten memiliki tinggi minimal 100% */
            overflow: auto; /* Tambahkan scroll jika konten panjang */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">Dashboard Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.motor') }}" class="nav-link">
                                <i class="nav-icon fas fa-motorcycle"></i>
                                <p>Manage Motors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>   
                        <li class="nav-item">
                            <a href="{{ route('admin.checkouts') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manage Checkout</p>
                            </a>
                        </li>                   
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
    </div>
</body>
</html>
