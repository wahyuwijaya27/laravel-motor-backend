@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Laporan Pendapatan</h1>
    
    <!-- Form Filter Tanggal -->
    <form method="GET" action="{{ route('reports.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Tanggal Mulai:</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">Tanggal Akhir:</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Motor ID</th>
                    <th>Nama Motor</th>
                    <th>Total Pendapatan</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->motor_id }}</td>
                        <td>{{ $report->motor_name }}</td>
                        <td>Rp{{ number_format($report->total_pendapatan, 2, ',', '.') }}</td>
                        <td>{{ $report->total_penjualan }}</td>
                    </tr>
                @endforeach
                <!-- Baris Total -->
                <tr class="table-info">
                    <td colspan="2" class="text-end"><strong>Total:</strong></td>
                    <td><strong>Rp{{ number_format($totalPendapatan, 2, ',', '.') }}</strong></td>
                    <td><strong>{{ $totalPenjualan }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
