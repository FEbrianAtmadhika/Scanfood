@extends('user.layout_2.app')
@section('title','Dashboard')

@section('content_section')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Gambar Deteksi -->
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset('images/' . Auth::guard()->user()->id . '/' . $uniqueImageName) }}" class="card-img-top" alt="Image">
            </div>
        </div>

        <!-- Form Deteksi -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Hasil Deteksi Makanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('deteksi') }}" method="POST">
                        @csrf
                        @foreach($classArray as $class)
                        <div class="form-group row align-items-center mb-3">
                            <label class="col-sm-4 col-form-label">{{ $class['nama'] }}</label>
                            <input type="hidden" name="image" value="{{ $uniqueImageName }}">
                            <div class="col-sm-4">
                                <input type="number" name="berat[{{ $class['class'] }}]" class="form-control" placeholder="Berat">
                            </div>
                            <div class="col-sm-4">
                                <span>grams</span>
                            </div>
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
