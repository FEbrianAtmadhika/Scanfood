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

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Pilih Tanggal:</label>
                                <input type="date" id="date" name="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="filterDate" class="btn btn-primary mt-4">Tampilkan</button>
                        </div>
                    </div>

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

                    <table class="table table-bordered" id="resultTable">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="resultBody" class="d-none">
                            @foreach ($results as $result)
                                <tr data-date="{{ $result->created_at->format('Y-m-d') }}"
                                    data-karbohidrat="{{ $result->karbohidrat }}"
                                    data-energi="{{ $result->energi }}"
                                    data-protein="{{ $result->protein }}"
                                    data-lemak="{{ $result->lemak }}"
                                    data-vit-a="{{ $result->Vit_A }}"
                                    data-vit-b="{{ $result->Vit_B }}"
                                    data-vit-c="{{ $result->Vit_C }}"
                                    data-kalsium="{{ $result->Kalsium }}"
                                    data-zat-besi="{{ $result->Zat_Besi }}"
                                    data-zink="{{ $result->Zink }}"
                                    data-tembaga="{{ $result->Tembaga }}"
                                    data-serat="{{ $result->serat }}"
                                    data-fosfor="{{ $result->fosfor }}"
                                    data-air="{{ $result->air }}"
                                    data-natrium="{{ $result->natrium }}"
                                    data-kalium="{{ $result->kalium }}">
                                    <td>{{ $result->user->name }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $result->user->id . '/' . $result->image) }}" alt="Image" style="width: 100px; height: auto;">
                                    </td>
                                    <td>
                                        <a href="{{ route('detail', $result->id) }}" class="btn btn-info">Lihat Detail</a>
                                        <a href="{{ route('hapus', $result->id) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus hasil ini?')">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-5">
                        <h4>Perbandingan Nilai Nutrisi</h4>
                        <table class="table table-bordered" id="nutrientComparisonTable">
                            <thead>
                                <tr>
                                    <th>Jenis Nutrisi</th>
                                    <th>Perolehan Nutrisi Hari Ini</th>
                                    <th>Kebutuhan Nutrisi Hari Ini</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Karbohidrat</td>
                                    <td id="totalKarbohidrat">0 g</td>
                                    <td>{{ number_format(Auth::guard()->user()->karbohidrat, 2) }} g</td>
                                    <td id="statusKarbohidrat">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Energi</td>
                                    <td id="totalEnergi">0 kkal</td>
                                    <td>{{ number_format(Auth::guard()->user()->energi, 2) }} kkal</td>
                                    <td id="statusEnergi">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Protein</td>
                                    <td id="totalProtein">0 g</td>
                                    <td>{{ number_format(Auth::guard()->user()->protein, 2) }} g</td>
                                    <td id="statusProtein">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Lemak</td>
                                    <td id="totalLemak">0 g</td>
                                    <td>{{ number_format(Auth::guard()->user()->lemak, 2) }} g</td>
                                    <td id="statusLemak">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Vitamin A</td>
                                    <td id="totalVitA">0 mcg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Vit_A, 2) }} mcg</td>
                                    <td id="statusVitA">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Vitamin B</td>
                                    <td id="totalVitB">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Vit_B, 2) }} mg</td>
                                    <td id="statusVitB">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Vitamin C</td>
                                    <td id="totalVitC">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Vit_C, 2) }} mg</td>
                                    <td id="statusVitC">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Kalsium</td>
                                    <td id="totalKalsium">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Kalsium, 2) }} mg</td>
                                    <td id="statusKalsium">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Zat Besi</td>
                                    <td id="totalZatBesi">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Zat_Besi, 2) }} mg</td>
                                    <td id="statusZatBesi">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Zink</td>
                                    <td id="totalZink">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Zink, 2) }} mg</td>
                                    <td id="statusZink">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Tembaga</td>
                                    <td id="totalTembaga">0 mcg</td>
                                    <td>{{ number_format(Auth::guard()->user()->Tembaga, 2) }} mcg</td>
                                    <td id="statusTembaga">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Serat</td>
                                    <td id="totalSerat">0 g</td>
                                    <td>{{ number_format(Auth::guard()->user()->serat, 2) }} g</td>
                                    <td id="statusSerat">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Fosfor</td>
                                    <td id="totalFosfor">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->fosfor, 2) }} mg</td>
                                    <td id="statusFosfor">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Air</td>
                                    <td id="totalAir">0 g</td>
                                    <td>{{ number_format(Auth::guard()->user()->air, 2) }} g</td>
                                    <td id="statusAir">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Natrium</td>
                                    <td id="totalNatrium">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->natrium, 2) }} mg</td>
                                    <td id="statusNatrium">Belum Tercapai</td>
                                </tr>
                                <tr>
                                    <td>Kalium</td>
                                    <td id="totalKalium">0 mg</td>
                                    <td>{{ number_format(Auth::guard()->user()->kalium, 2) }} mg</td>
                                    <td id="statusKalium">Belum Tercapai</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const filterButton = document.getElementById('filterDate');
    const resultBody = document.getElementById('resultBody');
    const rows = resultBody.querySelectorAll('tr');

    filterButton.addEventListener('click', function() {
        const selectedDate = dateInput.value;

        // Inisialisasi ulang totals setiap kali filter diaktifkan
        const totals = {
            karbohidrat: 0,
            energi: 0,
            protein: 0,
            lemak: 0,
            vitA: 0,
            vitB: 0,
            vitC: 0,
            kalsium: 0,
            zatBesi: 0,
            zink: 0,
            tembaga: 0,
            serat: 0,
            fosfor: 0,
            air: 0,
            natrium: 0,
            kalium: 0,
        };

        let hasVisibleRow = false;

        rows.forEach(row => {
            const rowDate = row.getAttribute('data-date');

            if (rowDate === selectedDate) {
                row.style.display = '';
                hasVisibleRow = true;
                totals.karbohidrat += parseFloat(row.getAttribute('data-karbohidrat')) || 0;
                totals.energi += parseFloat(row.getAttribute('data-energi')) || 0;
                totals.protein += parseFloat(row.getAttribute('data-protein')) || 0;
                totals.lemak += parseFloat(row.getAttribute('data-lemak')) || 0;
                totals.vitA += parseFloat(row.getAttribute('data-vit-a')) || 0;
                totals.vitB += parseFloat(row.getAttribute('data-vit-b')) || 0;
                totals.vitC += parseFloat(row.getAttribute('data-vit-c')) || 0;
                totals.kalsium += parseFloat(row.getAttribute('data-kalsium')) || 0;
                totals.zatBesi += parseFloat(row.getAttribute('data-zat-besi')) || 0;
                totals.zink += parseFloat(row.getAttribute('data-zink')) || 0;
                totals.tembaga += parseFloat(row.getAttribute('data-tembaga')) || 0;
                totals.serat += parseFloat(row.getAttribute('data-serat')) || 0;
                totals.fosfor += parseFloat(row.getAttribute('data-fosfor')) || 0;
                totals.air += parseFloat(row.getAttribute('data-air')) || 0;
                totals.natrium += parseFloat(row.getAttribute('data-natrium')) || 0;
                totals.kalium += parseFloat(row.getAttribute('data-kalium')) || 0;
            } else {
                row.style.display = 'none';
            }
        });

        if (hasVisibleRow) {
            resultBody.classList.remove('d-none');
        } else {
            resultBody.classList.add('d-none');
        }

        const userNeeds = {
            karbohidrat: {{ Auth::guard()->user()->karbohidrat }},
            energi: {{ Auth::guard()->user()->energi }},
            protein: {{ Auth::guard()->user()->protein }},
            lemak: {{ Auth::guard()->user()->lemak }},
            vitA: {{ Auth::guard()->user()->Vit_A }},
            vitB: {{ Auth::guard()->user()->Vit_B }},
            vitC: {{ Auth::guard()->user()->Vit_C }},
            kalsium: {{ Auth::guard()->user()->Kalsium }},
            zatBesi: {{ Auth::guard()->user()->Zat_Besi }},
            zink: {{ Auth::guard()->user()->Zink }},
            tembaga: {{ Auth::guard()->user()->Tembaga }},
            serat: {{ Auth::guard()->user()->serat }},
            fosfor: {{ Auth::guard()->user()->fosfor }},
            air: {{ Auth::guard()->user()->air }},
            natrium: {{ Auth::guard()->user()->natrium }},
            kalium: {{ Auth::guard()->user()->kalium }},
        };

        document.getElementById('totalKarbohidrat').textContent = `${totals.karbohidrat.toFixed(2)} g`;
        document.getElementById('statusKarbohidrat').textContent = totals.karbohidrat >= userNeeds.karbohidrat ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalEnergi').textContent = `${totals.energi.toFixed(2)} kkal`;
        document.getElementById('statusEnergi').textContent = totals.energi >= userNeeds.energi ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalProtein').textContent = `${totals.protein.toFixed(2)} g`;
        document.getElementById('statusProtein').textContent = totals.protein >= userNeeds.protein ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalLemak').textContent = `${totals.lemak.toFixed(2)} g`;
        document.getElementById('statusLemak').textContent = totals.lemak >= userNeeds.lemak ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalVitA').textContent = `${totals.vitA.toFixed(2)} mcg`;
        document.getElementById('statusVitA').textContent = totals.vitA >= userNeeds.vitA ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalVitB').textContent = `${totals.vitB.toFixed(2)} mg`;
        document.getElementById('statusVitB').textContent = totals.vitB >= userNeeds.vitB ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalVitC').textContent = `${totals.vitC.toFixed(2)} mg`;
        document.getElementById('statusVitC').textContent = totals.vitC >= userNeeds.vitC ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalKalsium').textContent = `${totals.kalsium.toFixed(2)} mg`;
        document.getElementById('statusKalsium').textContent = totals.kalsium >= userNeeds.kalsium ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalZatBesi').textContent = `${totals.zatBesi.toFixed(2)} mg`;
        document.getElementById('statusZatBesi').textContent = totals.zatBesi >= userNeeds.zatBesi ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalZink').textContent = `${totals.zink.toFixed(2)} mg`;
        document.getElementById('statusZink').textContent = totals.zink >= userNeeds.zink ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalTembaga').textContent = `${totals.tembaga.toFixed(2)} mg`;
        document.getElementById('statusTembaga').textContent = totals.tembaga >= userNeeds.tembaga ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalSerat').textContent = `${totals.serat.toFixed(2)} g`;
        document.getElementById('statusSerat').textContent = totals.serat >= userNeeds.serat ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalFosfor').textContent = `${totals.fosfor.toFixed(2)} mg`;
        document.getElementById('statusFosfor').textContent = totals.fosfor >= userNeeds.fosfor ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalAir').textContent = `${totals.air.toFixed(2)} ml`;
        document.getElementById('statusAir').textContent = totals.air >= userNeeds.air ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalNatrium').textContent = `${totals.natrium.toFixed(2)} mg`;
        document.getElementById('statusNatrium').textContent = totals.natrium >= userNeeds.natrium ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';

        document.getElementById('totalKalium').textContent = `${totals.kalium.toFixed(2)} mg`;
        document.getElementById('statusKalium').textContent = totals.kalium >= userNeeds.kalium ? 'Kebutuhan Tercapai' : 'Kebutuhan Belum Tercapai';
    });
});


</script>

@endsection
