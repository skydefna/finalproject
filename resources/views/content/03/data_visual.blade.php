@extends('content.03.menu_pimpinan')

@section('title', 'Lain Mata')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Visual</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="{{route('pimpinan.beranda')}}">Beranda</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="content mt-3">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="card text-white bg-primary rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Usulan:</p>
                            <h4 class="mb-0">{{ $jumlahPengajuan }}</h4>
                        </div>
                        <i class="fa fa-user fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Diajukan</p>
                            <h4>{{ $jumlahDiajukan }}</h4>
                        </div>
                        <i class="fa fa-hourglass-half fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Disetujui</p>
                            <h4>{{ $jumlahDisetujui }}</h4>
                        </div>
                        <i class="fa fa-check-circle fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Ditolak</p>
                            <h4>{{ $jumlahDitolak }}</h4>
                        </div>
                        <i class="fa fa-times-circle fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipe Koneksi -->
        <div class="row mt-4">
            <!-- Tipe Koneksi -->
            <div class="col-lg-6">
                <div class="card border rounded h-100">
                    <div class="card-header bg-light text-center">
                        <strong>Rekap Berdasarkan Tipe Koneksi</strong>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
                            <!-- PIE CHART -->
                            <div class="text-center" style="width: 300px; height: 300px;">
                                <canvas id="pieProviderChart" style="width: 100%; height: 100%;"></canvas>
                            </div>

                            <!-- TOTAL KONEKSI -->
                            <div id="totalTipeKoneksi" class="fw-bold text-center text-md-start">
                                <!-- Injected by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Aktif per Desa -->
            <div class="col-lg-6">
                <div class="card border rounded h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>Rekap Status Aktif per Desa/Kelurahan</strong>
                        <small class="text-muted">
                            {{ $jumlahDesaDalamRekap }} dari {{ $totalDesa }} desa/kelurahan
                        </small>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <canvas id="statusAktifChart" style="max-width:100%; height:auto; max-height:300px;"></canvas>
                            <div id="totalStatus" class="text-center mt-3 fw-bold"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border rounded">
                    <div class="card-header bg-light">
                        <strong>Rekap Jumlah WiFi per Desa/Kelurahan</strong>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <div class="mt-4">
                                <canvas id="wifiPerDesaChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- WiFi per Kecamatan Chart -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border rounded">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>Rekap Jumlah WiFi per Kecamatan</strong>
                        <small class="text-muted">
                            {{ $jumlahKecamatanDalamRekap }} dari {{ $totalKecamatan }} kecamatan
                        </small>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <div class="mt-4">
                                <canvas id="wifiBarChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // --- PIE CHART: Tipe Koneksi ---
            const tipeKoneksiData = @json($rekapTipeKoneksi);
            const pieLabels = tipeKoneksiData.map(item => item.tipe_koneksi ?? 'Tidak Diisi');
            const pieData = tipeKoneksiData.map(item => item.total);

            const pieCtx = document.getElementById('pieProviderChart').getContext('2d');
            new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // <<< ini penting
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

            // Tampilkan total per tipe koneksi dan total keseluruhan
            let total = 0;
            let detailText = '';

            tipeKoneksiData.forEach(item => {
                const label = item.tipe_koneksi ?? 'Tidak Diisi';
                const count = item.total;
                detailText += `${label}: ${count}<br>`;
                total += count;
            });

            detailText += `<br><strong>Total Koneksi: ${total}</strong>`;
            document.getElementById('totalTipeKoneksi').innerHTML = detailText;

            // --- BAR CHART: Jumlah WiFi per Kecamatan ---
            const wifiPerKecamatanData = @json($rekapPerKecamatan);
            const barLabelsKecamatan = wifiPerKecamatanData.map(item => item.nama_kecamatan);
            const barDataKecamatan = wifiPerKecamatanData.map(item => item.total_wifi);

            const barCtx = document.getElementById('wifiBarChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: barLabelsKecamatan,
                    datasets: [{
                        label: 'Jumlah WiFi Per Kecamatan',
                        data: barDataKecamatan,
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 30 // tambah ruang untuk datalabel
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom' // legend pindah ke bawah
                        },
                        tooltip: {
                            enabled: true
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            offset: 8, // jarak dari batang ke angka
                            color: '#000',
                            font: {
                                weight: 'bold'
                            },
                            formatter: function(value) {
                                return value;
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });

            // --- BAR CHART: Status Aktif/Mati per Desa/Kelurahan ---
            const rawStatusData = @json($rekapStatusAktifPerDesa);

            // Ambil nama desa unik untuk label chart status
            const desaLabelsStatus = [...new Set(rawStatusData.map(item => item.nama_desa_kelurahan))];

            // Buat map untuk status Aktif dan Mati
            const statusMap = {};
            desaLabelsStatus.forEach(desa => {
                statusMap[desa] = { Aktif: 0, Mati: 0 };
            });

            rawStatusData.forEach(item => {
                statusMap[item.nama_desa_kelurahan][item.status] = item.total;
            });

            // ✅ Sekarang definisikan aktifData dan matiData
            const aktifData = desaLabelsStatus.map(desa => statusMap[desa].Aktif);
            const matiData = desaLabelsStatus.map(desa => statusMap[desa].Mati);

            // ✅ Setelah itu baru hitung total
            const totalAktif = aktifData.reduce((a, b) => a + b, 0);
            const totalMati = matiData.reduce((a, b) => a + b, 0);

            // ✅ Tampilkan hasil total
            document.getElementById('totalStatus').innerHTML = `
                Total Aktif: <span class="text-success">${totalAktif}</span> |
                Total Mati: <span class="text-danger">${totalMati}</span>
            `;

            // Buat chart-nya
            const ctxStatus = document.getElementById('statusAktifChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'bar',
                data: {
                    labels: desaLabelsStatus,
                    datasets: [
                        {
                            label: 'Aktif',
                            data: aktifData,
                            backgroundColor: '#28a745'
                        },
                        {
                            label: 'Mati',
                            data: matiData,
                            backgroundColor: '#dc3545'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            beginAtZero: true,
                            stacked: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // --- BAR CHART: Jumlah WiFi per Desa/Kelurahan ---
            const wifiPerDesaDataRaw = @json($rekapPerDesa);
            const wifiPerDesaData = wifiPerDesaDataRaw.filter(item => {
                const jumlah = Number(item.total_wifi);
                return !isNaN(jumlah) && jumlah > 0;
            });

            const desaLabelsWifi = wifiPerDesaData.map(item => item.nama_desa_kelurahan ?? 'Tidak Diisi');
            const wifiTotals = wifiPerDesaData.map(item => Number(item.total_wifi));

            // Debugging (opsional)
            console.log('Filtered Data:', wifiPerDesaData);

            const ctxWifiPerDesa = document.getElementById('wifiPerDesaChart').getContext('2d');
            new Chart(ctxWifiPerDesa, {
                type: 'bar',
                data: {
                    labels: desaLabelsWifi,
                    datasets: [{
                        label: 'Jumlah WiFi Per Desa/Kelurahan',
                        data: wifiTotals,
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 30 // tambah ruang untuk datalabel
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom' // legend pindah ke bawah
                        },
                        tooltip: {
                            enabled: true
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            offset: 8, // jarak dari batang ke angka
                            color: '#000',
                            font: {
                                weight: 'bold'
                            },
                            formatter: function(value) {
                                return value;
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        </script>
    </div>
</div>
@endsection