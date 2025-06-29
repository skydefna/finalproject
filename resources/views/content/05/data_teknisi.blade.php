
@extends('content.05.menu_akun')

@section('title', 'Lain Mata')

@section('breadcrumbs')

@endsection

@section('content')
<div class="content mt-3">
    @csrf
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Data Survei Lain Mata</strong>
                <div class="d-flex align-items-center">
                    <ol type="button" class="breadcrumb rounded mb-1 mr-2">
                        <li><a href="{{ route('akun.keseluruhan.tabel') }}">Beranda</a></li>
                    </ol>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table" class="table table-bordered">
                    <thead>
                        <tr style="text-align:center;">
                            <th>No</th>
                            <th>Nama PIC Lokasi</th>
                            <th>Nama Lokasi</th>
                            <th>IP Assigment</th>
                            <th>Tipe Koneksi</th>
                            <th>Kecamatan</th>
                            <th>Desa / Kelurahan</th>
                            <th>Tanggal Pemasangan</th>
                            <th>Aksi</th>                                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemasangan as $id=>$db)
                            <tr>
                                <td style="vertical-align: middle">{{ $id+1 }}</td>
                                <td style="vertical-align: middle">{{ $db->pengajuan->nama_pic_lokasi }}</td>
                                <td style="text-align:center; vertical-align: middle;">
                                    @foreach ($db->lokasi as $lok)
                                        {{ $lok->nama_lokasi }}<br>
                                    @endforeach
                                </td>
                                <td style="text-align:center; vertical-align: middle;">{{ $db->ip_assigment }}</td>
                                <td style="text-align:center; vertical-align: middle;">
                                    @foreach ($db->provider as $pro)
                                        {{ $pro->nama_provider }}<br>
                                    @endforeach
                                </td>
                                <td style="vertical-align: middle;">
                                    {{ $db->pengajuan->kecamatan->nama_kecamatan ?? '-' }}
                                </td>
                                <td style="vertical-align: middle;">
                                    {{ $db->pengajuan->desakelurahan->nama_desa_kelurahan ?? '-' }}
                                </td>
                                <td style="text-align:center; vertical-align: middle;">{{ $db->tanggal_pemasangan }}</td>
                                <td style="text-align:center; vertical-align: middle;">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_pemasangan }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $('#bootstrap-data-table').DataTable({
                            "paging": true,       // pagination aktif
                            "searching": true,    // fitur pencarian aktif
                            "ordering": true,     // fitur sorting aktif
                            "order": [],          // default: tidak ada sorting aktif
                            "columnDefs": [
                                { "orderable": false, "targets": [5] } 
                            ],
                            "language": {
                                decimal: ",",
                                thousands: ".",
                                emptyTable: "Tidak ada data yang tersedia pada tabel",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                                infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                                infoPostFix: "",
                                lengthMenu: "Tampilkan _MENU_ entri",
                                loadingRecords: "Memuat...",
                                processing: "Memproses...",
                                search: "Cari:",
                                zeroRecords: "Tidak ditemukan data yang sesuai",
                                paginate: {
                                    first: "Pertama",
                                    last: "Terakhir",
                                    next: "Berikutnya",
                                    previous: "Sebelumnya"
                                }
                            }
                        });
                    });
                </script>
            </div> 
        </div>
    </div>

    @foreach ($pemasangan as $db)
        <div class="modal fade" id="modalReview{{ $db->id_pemasangan }}" tabindex="-1" aria-labelledby="modalLabel{{ $db->id_pemasangan }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $db->id_pemasangan }}">Detail Usulan:</h5>
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
                            <div class="row mb-4">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama Pengusul:</div>
                                        <div>{{ $db->pengajuan->nama_pic_lokasi }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">IP Assignment:</div>
                                        <div>{{ $db->ip_assigment }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Tipe Koneksi:</div>
                                        <div>
                                            @foreach ($db->provider as $prov)
                                                {{ $prov->nama_provider }}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Tipe Alat:</div>
                                        <div>{{ $db->tipe_alat }}</div>
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
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 180px;">Tanggal Pemasangan:</div>
                                        <div>{{ $db->tanggal_pemasangan }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- 🔽 Garis pembatas setelah detail --}}
                            <hr class="my-4">

                            {{-- Dokumentasi --}}
                            @php $dokumentasi = json_decode($db->dokumentasi_pemasangan, true); @endphp
                            @if ($dokumentasi)
                                <div class="mt-4 text-center">
                                    <h5 class="fw-bold">Dokumentasi</h5>
                                </div>

                                <div class="container">
                                    @if (count($dokumentasi) === 1)
                                        @php
                                            $url = asset('storage/' . $dokumentasi[0]);
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
                                        @foreach (array_chunk($dokumentasi, 2) as $row)
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

                            {{-- 🔽 Garis pembatas setelah dokumentasi --}}
                            <hr class="my-4">

                            {{-- Kontak PIC --}}
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Kontak PIC:</div>
                                <div class="col-md-9">
                                    <a href="{{ $linkWhatsapp }}" target="_blank" class="text-success text-decoration-none">
                                        <i class="fab fa-whatsapp"></i> {{ $db->pengajuan->kontak_pic_lokasi }}
                                    </a>
                                </div>
                            </div>

                            {{-- Lokasi & Peta --}}
                            @if ($db->lokasi->count())
                                <div class="row mb-2 border-bottom pb-1">
                                    <div class="col-md-3 fw-bold">Lokasi</div>
                                    <div class="col-md-9">
                                        @foreach ($db->lokasi as $lokasi)
                                            <div class="row mb-1">
                                                <div class="col-md-4"><strong>{{ $lokasi->nama_lokasi }}</strong></div>
                                                <div class="col-md-4 text-muted small">Lat: {{ $lokasi->latitude }}</div>
                                                <div class="col-md-4 text-muted small">Long: {{ $lokasi->longitude }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary btn-sm mb-2 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#mapCollapse{{ $db->id_pengajuan }}">
                                            Tampilkan Peta
                                        </button>
                                        <div class="collapse" id="mapCollapse{{ $db->id_pengajuan }}">
                                            <div id="map{{ $db->id_pengajuan }}" style="width: 100%; height: 300px; border-radius: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach   
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var lokasiData = @json($db->lokasi);
        var mapContainerId = "map{{ $db->id_pengajuan }}";

        if (lokasiData.length > 0 && document.getElementById(mapContainerId)) {
            var map = L.map(mapContainerId).setView([lokasiData[0].latitude, lokasiData[0].longitude], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            lokasiData.forEach(function (lokasi) {
                L.marker([lokasi.latitude, lokasi.longitude])
                    .addTo(map)
                    .bindPopup(lokasi.nama_lokasi);
            });
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
@endsection