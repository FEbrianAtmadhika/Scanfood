@extends('user.layout_2.app')
@section('title','Dashboard')

@section('content_section')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Biodata Bayi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    {{-- Error handling --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Input --}}
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
                        {{-- Data tampil --}}
                        <div class="mb-3">
                            <h4>Data Biodata Bayi</h4>
                            <p><strong>Berat Badan:</strong> {{ Auth::guard()->user()->berat }} kg</p>
                            <p><strong>Tinggi Badan:</strong> {{ Auth::guard()->user()->tinggi }} cm</p>
                            <a href="" class="btn btn-secondary">Perbarui Informasi</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
