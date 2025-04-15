@extends('user.layout_2.app')
@section('title','Dashboard')

@section('content_section')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Tombol Kembali -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-start mb-3">
                <a href="{{ route('scan') }}" class="btn btn-primary" onclick="clearHistory()">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Gambar dan Detail Makanan -->
    <div class="row">
        <!-- Gambar -->
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset('images/' . Auth::guard()->user()->id . '/' . $imageName) }}" class="card-img-top" alt="Image">
            </div>
        </div>

        <!-- Detail Makanan -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Hasil Deteksi Makanan</h4>
                </div>
                <div class="card-body">
                    <h5>Detail Makanan</h5>
                    <ul class="list-unstyled">
                        @foreach ($foodResults as $foodResult)
                            <li>
                                {{ $foodResult->food->nama }} - Berat: {{ $foodResult->weight }} g
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Hasil Nutrisi -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Hasil Nutrisi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Komponen</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Karbohidrat</td><td>{{ $result->karbohidrat }} g</td></tr>
                            <tr><td>Energi</td><td>{{ $result->energi }} kkal</td></tr>
                            <tr><td>Protein</td><td>{{ $result->protein }} g</td></tr>
                            <tr><td>Lemak</td><td>{{ $result->lemak }} g</td></tr>
                            <tr><td>Vitamin A</td><td>{{ $result->Vit_A }} mcg</td></tr>
                            <tr><td>Vitamin B</td><td>{{ $result->Vit_B }} mg</td></tr>
                            <tr><td>Vitamin C</td><td>{{ $result->Vit_C }} mg</td></tr>
                            <tr><td>Kalsium</td><td>{{ $result->Kalsium }} mg</td></tr>
                            <tr><td>Zat Besi</td><td>{{ $result->Zat_Besi }} mg</td></tr>
                            <tr><td>Zink</td><td>{{ $result->Zink }} mg</td></tr>
                            <tr><td>Tembaga</td><td>{{ $result->Tembaga }} mcg</td></tr>
                            <tr><td>Serat</td><td>{{ $result->serat }} g</td></tr>
                            <tr><td>Fosfor</td><td>{{ $result->fosfor }} mg</td></tr>
                            <tr><td>Air</td><td>{{ $result->air }} g</td></tr>
                            <tr><td>Natrium</td><td>{{ $result->natrium }} mg</td></tr>
                            <tr><td>Kalium</td><td>{{ $result->kalium }} mg</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@section('scripts')
<script>
    function clearHistory() {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    }
</script>
@endsection

@endsection
