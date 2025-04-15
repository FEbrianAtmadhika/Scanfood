@extends('user.layout_2.app')
@section('title','Dashboard')

@section('content_section')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">History Deteksi Gambar</h6>
                    </div>
                    <!-- Card Body -->
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
                        <div class="row" id="circleCharts">
                            <!-- Nanti akan diisi dinamis lewat JavaScript -->
                        </div>

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
                                        <td id="totalTembaga">0 mg</td>
                                        <td>{{ number_format(Auth::guard()->user()->Tembaga, 2) }} mg</td>
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
                                        <td id="totalAir">0 ml</td>
                                        <td>{{ number_format(Auth::guard()->user()->air, 2) }} ml</td>
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
    <!-- /.container-fluid -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dataUser = @json(Auth::guard()->user());
            const dateInput = document.getElementById('date');
            const filterButton = document.getElementById('filterDate');
            const resultBody = document.getElementById('resultBody');
            const rows = resultBody.querySelectorAll('tr');
            const chartContainer = document.getElementById('circleCharts');
            const charts = {}; // Menyimpan instance Chart.js

            // Mapping satuan unit untuk tiap zat gizi
            const unitMapping = {
                karbohidrat: 'g',
                energi: 'kkal',
                protein: 'g',
                lemak: 'g',
                vitA: 'mcg',
                vitB: 'mg',
                vitC: 'mg',
                kalsium: 'mg',
                zatBesi: 'mg',
                zink: 'mg',
                tembaga: 'mg',
                serat: 'g',
                fosfor: 'mg',
                air: 'ml',
                natrium: 'mg',
                kalium: 'mg',
            };

            filterButton.addEventListener('click', function () {
                const selectedDate = dateInput.value;

                // Initialize totals
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

                        // Tambahkan nilai-nilai dari atribut
                        Object.keys(totals).forEach(key => {
                            const attr = row.getAttribute(`data-${key.replace(/([A-Z])/g, '-$1').toLowerCase()}`);
                            totals[key] += parseFloat(attr) || 0;
                        });

                    } else {
                        row.style.display = 'none';
                    }
                });

                resultBody.classList.toggle('d-none', !hasVisibleRow);

                const userNeeds = {
                    karbohidrat: dataUser.karbohidrat,
                    energi: dataUser.energi,
                    protein: dataUser.protein,
                    lemak: dataUser.lemak,
                    vitA: dataUser.Vit_A,
                    vitB: dataUser.Vit_B,
                    vitC: dataUser.Vit_C,
                    kalsium: dataUser.Kalsium,
                    zatBesi: dataUser.Zat_Besi,
                    zink: dataUser.Zink,
                    tembaga: dataUser.Tembaga,
                    serat: dataUser.serat,
                    fosfor: dataUser.fosfor,
                    air: dataUser.air,
                    natrium: dataUser.natrium,
                    kalium: dataUser.kalium,
                };

                // Bersihkan kontainer chart sebelum diisi ulang
                chartContainer.innerHTML = '';

                // Render chart hanya untuk 6 komponen gizi
                const selectedKeys = ['karbohidrat', 'energi', 'protein', 'lemak', 'kalsium', 'zatBesi'];

                selectedKeys.forEach(key => {
                    // Update total dan status teks dengan unit yang benar
                    const unit = unitMapping[key];
                    document.getElementById(`total${capitalizeFirstLetter(key)}`).innerText = `${totals[key]} ${unit}`;

                    const statusElement = document.getElementById(`status${capitalizeFirstLetter(key)}`);
                    if (totals[key] >= userNeeds[key]) {
                        statusElement.innerText = 'Tercapai';
                        statusElement.classList.remove('text-danger');
                        statusElement.classList.add('text-success');
                    } else {
                        statusElement.innerText = 'Belum Tercapai';
                        statusElement.classList.remove('text-success');
                        statusElement.classList.add('text-danger');
                    }

                    // Render chart hanya untuk komponen yang dipilih
                    renderChart(key, totals[key], userNeeds[key]);
                });
            });

            // Fungsi render chart lingkaran
            function renderChart(key, value, maxValue) {
                const percent = Math.min((value / maxValue) * 100, 100).toFixed(1);
                const canvasId = `chart-${key}`;
                const col = document.createElement('div');
                col.className = 'col-6 col-md-2 mb-4 d-flex justify-content-center'; // 6 card per row

                col.innerHTML = `
                    <div class="card shadow-sm text-center" style="width: 100%;">
                        <div class="card-header text-capitalize fw-bold py-1 px-2" style="font-size: 0.85rem;">${key}</div>
                        <div class="card-body p-2">
                            <div style="width: 100px; height: 100px; margin: 0 auto;">
                                <canvas id="${canvasId}" width="100" height="100"></canvas>
                            </div>
                            <p class="mt-2 mb-0" style="font-size: 0.75rem;">${percent}%</p>
                        </div>
                    </div>
                `;
                chartContainer.appendChild(col);

                const ctx = document.getElementById(canvasId).getContext('2d');
                charts[key] = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Tercapai', 'Sisa'],
                        datasets: [{
                            data: [value, Math.max(maxValue - value, 0)],
                            backgroundColor: ['#198754', '#dee2e6'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        }
                    }
                });
            }

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        });
    </script>


@endsection


