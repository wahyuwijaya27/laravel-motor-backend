@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h1 class="display-6">Daftar Checkout Pembelian</h1>
    </div>

    <!-- Card Wrapper -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat Lengkap</th>
                            <th>Nomor Telepon</th>
                            <th>Motor</th>
                            <th>Harga</th>
                            <th>Bukti Transaksi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkouts as $index => $checkout)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $checkout->user->id ?? '-' }}</td>
                            <td>{{ $checkout->nama_lengkap }}</td>
                            <td>{{ $checkout->alamat_lengkap }}</td>
                            <td>{{ $checkout->nomor_telepon }}</td>
                            <td>{{ $checkout->motor->name }}</td>
                            <td>Rp{{ number_format($checkout->motor->price, 0, ',', '.') }}</td>
                            <td>
                                @if($checkout->bukti_transaksi)
                                <a href="{{ asset('storage/' . $checkout->bukti_transaksi) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $checkout->bukti_transaksi) }}" alt="Bukti Transaksi" class="img-thumbnail" width="100">
                                </a>
                                @else
                                <span class="text-muted">Tidak ada bukti</span>
                                @endif
                            </td>
                            <td>{{ $checkout->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
