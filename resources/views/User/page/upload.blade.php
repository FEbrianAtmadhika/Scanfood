@extends('User.layout.app')

@section('title', 'Dashboard')

@section('main_content')
<div class="card m-5 h-100 p-5 d-flex justify-content-center align-items-center">
    <h2>Confirm Upload</h2>

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

    <!-- File Input for Image Upload -->
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image-input">Choose Image</label>
            <input type="file" class="form-control" name="image" id="image-input" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <!-- Canvas for displaying the uploaded image -->
    <canvas id="canvas" class="mt-4"></canvas>
</div>
@endsection
