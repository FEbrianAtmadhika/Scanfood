<!-- resources/views/User/page/history.blade.php -->
@extends('User.layout.app')

@section('title', 'History Deteksi')

@section('main_content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>History Deteksi Gambar</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr>
                                    <td>{{ $result->user->name }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $result->user->id . '/' . $result->image) }}" alt="Image" style="width: 100px; height: auto;">
                                    </td>
                                    <td>
                                        <a href="{{ route('detail', $result->id) }}" class="btn btn-info">Lihat Detail</a>
                                        <a href="{{ route('hapus', $result->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this result?')">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
