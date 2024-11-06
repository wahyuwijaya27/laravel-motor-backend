@extends('admin.layout')

@section('content')
<h1>Edit Motor</h1>

<!-- Menampilkan pesan sukses -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Form untuk mengedit motor -->
<form action="{{ route('admin.motor.update', $motor->id) }}" method="POST" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
    @csrf
    @method('PUT') <!-- Metode PUT untuk update -->
    
    <div class="form-group">
        <label for="name">Nama Motor:</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $motor->name) }}" required>
    </div>
    <div class="form-group">
        <label for="brand">Merk Motor:</label>
        <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $motor->brand) }}" required>
    </div>
    <div class="form-group">
        <label for="year">Tahun:</label>
        <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $motor->year) }}" required>
    </div>
    <div class="form-group">
        <label for="price">Harga:</label>
        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $motor->price) }}" required>
    </div>
    <div class="form-group">
        <label for="specification">Spesifikasi Motor:</label>
        <textarea name="specification" id="specification" class="form-control" rows="5">{{ old('specification', $motor->specification ?? '') }}</textarea>
    </div>
    
    <div class="form-group">
        <label for="image">Gambar Motor:</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        
        <!-- Menampilkan gambar lama jika ada -->
        @if ($motor->image)
            <div class="mt-2">
                <label>Gambar Saat Ini:</label>
                <img src="{{ asset('storage/' . $motor->image) }}" alt="Gambar Motor" width="100">
            </div>
        @else
            <p>Tidak ada gambar saat ini.</p>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary">Perbarui Motor</button>
</form>

<a href="{{ route('admin.motor') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Motor</a>
@endsection
