@extends('User.layout.app')

@section('title', 'Detail Hasil Deteksi')

@section('main_content')
<div class="container mt-5">
    <div class="row">
        <!-- Image Section -->
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/' . $result->user->id . '/' . $result->image) }}" class="card-img-top" alt="Image">
            </div>
        </div>

        <!-- Detected Food List Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Hasil Deteksi Makanan</h4>
                </div>
                <div class="card-body">
                    <h5>Detail Makanan</h5>
                    <ul class="list-unstyled">
                        @foreach ($foodResults as $foodResult)
                            <li>
                                {{ $foodResult->food->nama }} - Berat: {{ str_replace('.', ',', rtrim(rtrim($foodResult->weight, '0'), ',')) }} g
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Nutritional Information Table Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
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
                            @php
                                function formatNumber($number) {
                                    return str_replace('.', ',', rtrim(rtrim($number, '0'), ','));
                                }
                            @endphp
                            <tr>
                                <td>Karbohidrat</td>
                                <td>{{ formatNumber($result->karbohidrat) }} g</td>
                            </tr>
                            <tr>
                                <td>Energi</td>
                                <td>{{ formatNumber($result->energi) }} kkal</td>
                            </tr>
                            <tr>
                                <td>Protein</td>
                                <td>{{ formatNumber($result->protein) }} g</td>
                            </tr>
                            <tr>
                                <td>Lemak</td>
                                <td>{{ formatNumber($result->lemak) }} g</td>
                            </tr>
                            <tr>
                                <td>Vitamin A</td>
                                <td>{{ formatNumber($result->Vit_A) }} mcg</td>
                            </tr>
                            <tr>
                                <td>Vitamin B</td>
                                <td>{{ formatNumber($result->Vit_B) }} mg</td>
                            </tr>
                            <tr>
                                <td>Vitamin C</td>
                                <td>{{ formatNumber($result->Vit_C) }} mg</td>
                            </tr>
                            <tr>
                                <td>Kalsium</td>
                                <td>{{ formatNumber($result->Kalsium) }} mg</td>
                            </tr>
                            <tr>
                                <td>Zat Besi</td>
                                <td>{{ formatNumber($result->Zat_Besi) }} mg</td>
                            </tr>
                            <tr>
                                <td>Zink</td>
                                <td>{{ formatNumber($result->Zink) }} mg</td>
                            </tr>
                            <tr>
                                <td>Tembaga</td>
                                <td>{{ formatNumber($result->Tembaga) }} mcg</td>
                            </tr>
                            <tr>
                                <td>Serat</td>
                                <td>{{ formatNumber($result->serat) }} g</td>
                            </tr>
                            <tr>
                                <td>Fosfor</td>
                                <td>{{ formatNumber($result->fosfor) }} mg</td>
                            </tr>
                            <tr>
                                <td>Air</td>
                                <td>{{ formatNumber($result->air) }} g</td>
                            </tr>
                            <tr>
                                <td>Natrium</td>
                                <td>{{ formatNumber($result->natrium) }} mg</td>
                            </tr>
                            <tr>
                                <td>Kalium</td>
                                <td>{{ formatNumber($result->kalium) }} mg</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
