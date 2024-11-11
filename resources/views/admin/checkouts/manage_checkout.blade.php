@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Daftar Checkout Pembelian</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>User ID</th> <!-- Kolom User ID baru -->
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
                <td>{{ $checkout->user->id ?? '-' }}</td> <!-- Menampilkan User ID -->
                <td>{{ $checkout->nama_lengkap }}</td>
                <td>{{ $checkout->alamat_lengkap }}</td>
                <td>{{ $checkout->nomor_telepon }}</td>
                <td>{{ $checkout->motor->name }}</td>
                <td>Rp{{ number_format($checkout->motor->price, 0, ',', '.') }}</td>
                <td>
                    @if($checkout->bukti_transaksi)
                    <img src="{{ asset('storage/' . $checkout->bukti_transaksi) }}" alt="Bukti Transaksi" width="100">
                    @else
                    <span>Tidak ada bukti</span>
                    @endif
                </td>
                <td>{{ $checkout->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
