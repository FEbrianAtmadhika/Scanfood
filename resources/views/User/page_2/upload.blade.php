@extends('user.layout_2.app')
@section('title','Dashboard')

@section('content_section')
<!-- Begin Page Content -->
<div class="container-fluid">


    <div class="row">
        <!-- Card Biodata Bayi -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Unggah Image Makanan</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">


                    {{-- Session messages --}}
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

                    {{-- Upload Form --}}
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image-input">Choose Image</label>

                            <!-- Custom Input File -->
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="image-input" accept="image/*" placeholder="" required>
                                <label class="custom-file-label" for="image-input">Choose file...</label>
                            </div>

                            <!-- Display selected file name -->
                            <small class="form-text text-muted" id="file-name"></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    {{-- Canvas Preview --}}
                    <canvas id="canvas" class="mt-4"></canvas>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script>
    // Display selected file name
document.getElementById('image-input').addEventListener('change', function (e) {
    var fileName = e.target.files[0].name;
    e.target.nextElementSibling.textContent = fileName; // Update label with selected file name
    document.getElementById('file-name').textContent = "Selected file: " + fileName; // Optional: for a custom file name display
});
</script>
@endsection
