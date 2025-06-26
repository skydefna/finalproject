
@extends('content.03.menu_pimpinan')

@section('title', 'Lain Mata')

@section('breadcrumbs')

@endsection

@section('content')
<div class="content mt-3">
    @csrf
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Data Lapor Aduan Lain Mata</strong>
                <div class="d-flex align-items-center">
                    <ol type="button" class="breadcrumb rounded mb-1 mr-2">
                        <li><a href="{{ route('pimpinan.beranda') }}">Beranda</a></li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="tabel-aduan" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th style="text-align:center; vertical-align: middle;">No</th>
                                <th style="text-align:center; vertical-align: middle;">Lokasi</th>
                                <th style="text-align:center; vertical-align: middle;">Nama Pengusul</th>
                                <th style="text-align:center; vertical-align: middle;">Deskripsi</th>
                                <th style="text-align:center; vertical-align: middle;">Status</th>
                                <th style="text-align:center; vertical-align: middle;">Aksi</th>
                                <th style="text-align:center; vertical-align: middle;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aduan as $index => $db)
                            <tr>
                                <td style="text-align:center; vertical-align: middle;">{{ $index + 1 }}</td>
                                <td style="vertical-align: middle">{{ $db->lokasi->nama_lokasi ?? '-' }}</td>
                                <td style="vertical-align: middle">{{ $db->pengajuan->nama_pic_lokasi ?? '-' }}</td>
                                <td style="vertical-align: middle">{{ $db->deskripsi }}</td>
                                <td style="text-align:center; vertical-align: middle;">
                                    <span class="badge 
                                        @if($db->statusaduan->nama_status_aduan == 'Menunggu') badge-warning
                                        @elseif($db->statusaduan->nama_status_aduan == 'Menuju Lokasi') badge-info
                                        @elseif($db->statusaduan->nama_status_aduan == 'Selesai') badge-success
                                        @else badge-secondary @endif">
                                        {{ $db->statusaduan->nama_status_aduan ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $db->created_at->format('d-m-Y') }}</td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_aduan }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data aduan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#tabel-aduan').DataTable({
                responsive: true,
                order: [[0, 'asc']], // urut berdasarkan nomor
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                }
            });
        });
    </script>

    @foreach ($aduan as $db)
        <div class="modal fade" id="modalReview{{ $db->id_aduan }}" tabindex="-1" aria-labelledby="modalLabel{{ $db->id_aduan }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $db->id_aduan }}">Detail Aduan:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            @php
                                $lokasiUtama = $db->lokasi[0] ?? null;
                                $waNumber = preg_replace('/^0/', '62', $db->pengajuan->kontak_pic_lokasi);
                                $linkWhatsapp = "https://wa.me/$waNumber";
                            @endphp

                            {{-- DETAIL USULAN --}}
                            <div class="row mb-2 border-bottom pb-1">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama Lokasi:</div>
                                        <div>{{ $db->lokasi->nama_lokasi }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama PIC Lokasi:</div>
                                        <div>{{ $db->pengajuan->nama_pic_lokasi }}</div>
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 180px;">Kecamatan:</div>
                                        <div>{{ $db->pengajuan->kecamatan->nama_kecamatan ?? '-' }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 180px;">Desa / Kelurahan:</div>
                                        <div>{{ $db->pengajuan->desakelurahan->nama_desa_kelurahan ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 border-bottom pb-1">
                                <div class="col-md-3 fw-bold">Status Aduan:</div>
                                <div class="col-md-9">
                                    <span class="badge 
                                        @if($db->statusaduan->nama_status_aduan == 'Menunggu') badge-warning
                                        @elseif($db->statusaduan->nama_status_aduan == 'Menuju Lokasi') badge-info
                                        @elseif($db->statusaduan->nama_status_aduan == 'Selesai') badge-success
                                        @else badge-secondary @endif">
                                        {{ $db->statusaduan->nama_status_aduan ?? '-' }}
                                    </span>
                                </div>
                            </div>

                             <div class="row mb-2 border-bottom pb-1">
                                <div class="col-md-3 fw-bold">Alamat Aktual:</div>
                                <div class="col-md-9">
                                    {{ $db->pengajuan->alamat_aktual }}
                                </div>
                            </div>

                            <div class="row mb-2 border-bottom pb-1">
                                <div class="col-md-3 fw-bold">Deskripsi:</div>
                                <div class="col-md-9">
                                    <div>{{ $db->deskripsi }}</div>
                                </div>
                            </div>

                            @php
                                $foto = json_decode($db->foto, true);
                                if (!$foto) {
                                    $foto = [$db->foto]; // fallback jika bukan JSON
                                }
                            @endphp

                            @if ($foto && count($foto) > 0)

                                <div class="mt-4 text-center">
                                    <h5 class="fw-bold">Foto</h5>
                                </div>

                                <div class="container">
                                    @if (count($foto) === 1)
                                        @php
                                            $url = asset('storage/' . $foto[0]);
                                            $imgId = 'gambar_0';
                                        @endphp
                                        <div class="row justify-content-center mb-4">
                                            <div class="col-md-6 text-center">
                                                <img id="{{ $imgId }}" src="{{ $url }}" alt="Dokumentasi" class="img-fluid mb-2 border" style="max-height: 500px;">
                                                <br>
                                                <button onclick="unduhGambar('{{ $imgId }}')" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-download"></i> Unduh
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        @foreach (array_chunk($foto, 2) as $row)
                                            <div class="row mb-4">
                                                @foreach ($row as $index => $file)
                                                    @php
                                                        $url = asset('storage/' . $file);
                                                        $imgId = 'gambar_' . ($loop->parent->index * 2 + $index);
                                                    @endphp
                                                    <div class="col-md-6 text-center">
                                                        <img id="{{ $imgId }}" src="{{ $url }}" alt="Dokumentasi" class="img-fluid mb-2 border" style="max-height: 500px;">
                                                        <br>
                                                        <button onclick="unduhGambar('{{ $imgId }}')" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-download"></i> Unduh
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif

                            {{-- Lokasi & Peta --}}
                            @if ($db->lokasi)
                                <div class="row mb-2 border-bottom pb-1">
                                    <div class="col-md-3 fw-bold">Lokasi</div>
                                    <div class="col-md-9">
                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>{{ $db->lokasi->nama_lokasi }}</strong></div>
                                            <div class="col-md-4 text-muted small">Lat: {{ $db->lokasi->latitude }}</div>
                                            <div class="col-md-4 text-muted small">Long: {{ $db->lokasi->longitude }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary btn-sm mb-2 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#mapCollapse{{ $db->id_aduan }}">
                                            Tampilkan Peta
                                        </button>
                                        <div class="collapse" id="mapCollapse{{ $db->id_aduan }}">
                                            <div id="map{{ $db->id_aduan }}" style="width: 100%; height: 300px; border-radius: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>                
            document.addEventListener("DOMContentLoaded", function () {
                var lokasiData = @json($db->lokasi);
                var mapContainerId = "map{{ $db->id_aduan }}";

                if (lokasiData && document.getElementById(mapContainerId)) {
                    var map = L.map(mapContainerId).setView([lokasiData.latitude, lokasiData.longitude], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);

                    L.marker([lokasiData.latitude, lokasiData.longitude])
                        .addTo(map)
                        .bindPopup(lokasiData.nama_lokasi);
                }
            });

            function unduhGambar(id) {
                const gambar = document.getElementById(id);
                const a = document.createElement("a");
                a.href = gambar.src;
                a.download = "dokumentasi.jpg";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        </script>
    @endforeach  
</div>
@endsection