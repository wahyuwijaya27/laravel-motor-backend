@extends('admin.layout')

@section('content')
<h1>Manage Motor</h1>

<!-- Form untuk menambahkan motor -->
<form action="{{ route('admin.motor.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Nama Motor:</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="brand">Jenis Motor:</label>
        <input type="text" name="brand" id="brand" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="year">Tahun:</label>
        <input type="number" name="year" id="year" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="price">Harga:</label>
        <input type="number" name="price" id="price" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="specification">Spesifikasi Motor:</label>
        <textarea name="specification" id="specification" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <label for="image">Gambar Motor:</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-primary">Tambahkan Motor</button>
</form>

<hr>

<!-- Tabel untuk menampilkan daftar motor -->
<h2>Daftar Motor</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Motor</th>
            <th>Jenis</th>
            <th>Tahun</th>
            <th>Harga</th>
            <th>Spesifikasi</th> 
            <th>Gambar</th> 
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($motors as $motor)
            <tr>
                <td>{{ $motor->id }}</td>
                <td>{{ $motor->name }}</td>
                <td>{{ $motor->brand }}</td>
                <td>{{ $motor->year }}</td>
                <td>{{ number_format($motor->price, 0, ',', '.') }}</td>
                <td>{{ \Illuminate\Support\Str::limit($motor->specification, 30, '...') }}</td>
 <!-- Menampilkan spesifikasi motor -->
                <td>
                    @if ($motor->image)
                        <!-- Menampilkan gambar -->
                        <img src="{{ asset('storage/' . $motor->image) }}" alt="Gambar Motor" width="100">
                    @else
                        No Image
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.motor.edit', $motor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.motor.destroy', $motor->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus motor ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
