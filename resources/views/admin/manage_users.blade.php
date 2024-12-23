@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Manage Users</h2>

    <!-- Tampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
