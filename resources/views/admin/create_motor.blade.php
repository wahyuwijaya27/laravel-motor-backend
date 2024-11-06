@extends('admin.layout')

@section('title', 'Tambah Motor')

@section('content_header')
    <h1>Tambah Motor</h1>
@endsection

@section('content')
    <form action="{{ route('admin.motor.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Motor</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="brand">Merk</label>
            <input type="text" class="form-control" id="brand" name="brand" required>
        </div>
        <div class="form-group">
            <label for="year">Tahun</label>
            <input type="number" class="form-control" id="year" name="year" required>
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="specification">Spesifikasi Motor:</label>
            <textarea name="specification" id="specification" class="form-control" rows="5">{{ old('specification', $motor->specification ?? '') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
