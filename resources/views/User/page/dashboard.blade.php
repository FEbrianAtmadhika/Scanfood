@extends('User.layout.app')

@section('title', 'Dashboard')

@section('main_content')
<div class="card m-5 h-100 p-5 d-flex justify-content-center align-items-center">
    <h2>Biodata Bayi Dengan Umur 12-24 bulan</h2>

    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @if(Auth::guard()->user()->berat == null)
        <form action="{{ route('update_user') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="berat" class="form-label">Berat Badan (kg)</label>
                <input type="number" step="0.01" class="form-control" id="berat" name="berat" required>
                <small class="form-text text-muted">Gunakan titik (.) untuk pemisah desimal.</small>
            </div>
            <div class="mb-3">
                <label for="tinggi" class="form-label">Tinggi Badan (cm)</label>
                <input type="number" step="0.01" class="form-control" id="tinggi" name="tinggi" required>
                <small class="form-text text-muted">Gunakan titik (.) untuk pemisah desimal.</small>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    @else
        <div class="mb-3">
            <h4>Data Biodata Bayi</h4>
            <p><strong>Berat Badan:</strong> {{ Auth::guard()->user()->berat }} kg</p>
            <p><strong>Tinggi Badan:</strong> {{ Auth::guard()->user()->tinggi }} cm</p>
            <a href="" class="btn btn-secondary">Perbarui Informasi</a>
        </div>
    @endif
</div>
@endsection

