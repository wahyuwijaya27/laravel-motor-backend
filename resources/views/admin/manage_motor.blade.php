@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Manage Motor</h1>

    <!-- Form untuk menambahkan motor -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Tambah Motor Baru</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.motor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Motor:</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama motor" required>
                </div>
                <div class="mb-3">
                    <label for="brand" class="form-label">Jenis Motor:</label>
                    <select name="brand" id="brand" class="form-select" required>
                        <option value="Matic">Matic</option>
                        <option value="Bebek">Bebek</option>
                        <option value="Sport">Sport</option>
                        <option value="Trail">Trail</option>
                        <option value="Classic">Classic</option>
                        <option value="Moge">Moge</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Tahun:</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2022" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga:</label>
                    <input type="number" name="price" id="price" class="form-control" placeholder="Masukkan harga motor" required>
                </div>
                <div class="mb-3">
                    <label for="specification" class="form-label">Spesifikasi Motor:</label>
                    <textarea name="specification" id="specification" class="form-control" rows="4" placeholder="Deskripsikan spesifikasi motor" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Motor:</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-success">Tambahkan Motor</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Motor -->
    <h2 class="mb-3">Daftar Motor</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
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
                        <td>Rp{{ number_format($motor->price, 0, ',', '.') }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($motor->specification, 30, '...') }}</td>
                        <td>
                            @if ($motor->image)
                                <img src="{{ asset('storage/' . $motor->image) }}" alt="Gambar Motor" class="img-thumbnail" width="100">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.motor.edit', $motor->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
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
    </div>
</div>
@endsection
