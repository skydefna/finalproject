
@extends('content.02.menu_admin')

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
                        <li><a href="{{ route('admin.beranda') }}">Beranda</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bootstrap-data-table" class="table table-bordered w-100">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Surveyor</th>
                                    <th>Nama PIC Lokasi</th>
                                    <th>Nama Lokasi</th>
                                    <th>Kecamatan</th>
                                    <th>Desa / Kelurahan</th>
                                    <th>Tanggal Survei</th>
                                    <th>Status</th>
                                    <th class="d-none">Status Value</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($survei as $id => $db)
                                    <tr>
                                        <td class="align-middle text-center">{{ $id + 1 }}</td>
                                        <td class="align-middle">{{ $db->nama_surveyor }}</td>
                                        <td class="align-middle">{{ $db->pengajuan->nama_pic_lokasi }}</td>
                                        <td class="align-middle text-center">{{ $db->lokasi->nama_lokasi ?? '-' }}</td>
                                        <td class="align-middle">{{ $db->pengajuan->kecamatan->nama_kecamatan ?? '-' }}</td>
                                        <td class="align-middle">{{ $db->pengajuan->desakelurahan->nama_desa_kelurahan ?? '-' }}</td>
                                        <td class="align-middle text-center">{{ $db->tanggal_survei }}</td>
                                        <td class="align-middle text-center">
                                            @php
                                                $status = $db->pengajuan?->status->first(); // karena status adalah collection
                                                $class = match(strtolower($status->nama_status ?? '')) {
                                                    'diajukan' => 'badge bg-warning text-white',
                                                    'disetujui' => 'badge bg-success',
                                                    'ditolak' => 'badge bg-danger',
                                                    default => 'badge bg-secondary',
                                                };
                                            @endphp
                                            <span class="{{ $class }}">{{ $status->nama_status }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_survei }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                        <td class="d-none">{{ $statusName ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#bootstrap-data-table').DataTable({
                "responsive": true,
                "paging": true,       // pagination aktif
                "searching": true,    // fitur pencarian aktif
                "ordering": true,     // fitur sorting aktif
                "order": [],          // default: tidak ada sorting aktif
                "columnDefs": [
                    { "orderable": false, "targets": [9] } 
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

    @foreach ($survei as $db)
        <div class="modal fade" id="modalReview{{ $db->id_survei }}" tabindex="-1" aria-labelledby="modalLabel{{ $db->id_survei }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $db->id_survei }}">Detail Usulan:</h5>
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
                            <div class="row mb-4 border-bottom pb-1">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama Surveyor:</div>
                                        <div>{{ $db->nama_surveyor }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama PIC Lokasi:</div>
                                        <div>{{ $db->pengajuan->nama_pic_lokasi }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Kontak PIC:</div>
                                        <div>
                                            <a href="{{ $linkWhatsapp }}" target="_blank" class="text-success text-decoration-none">
                                                <i class="fab fa-whatsapp"></i> {{ $db->pengajuan->kontak_pic_lokasi }}
                                            </a>
                                        </div>  
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
                                        <div class="fw-bold me-2" style="min-width: 180px;">Tanggal Survei:</div>
                                        <div>{{ $db->tanggal_survei }}</div>
                                    </div>
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

                            <div class="row mb-2 border-bottom pb-2">
                                @php
                                    $status = $db->pengajuan?->status->first(); // karena status adalah collection
                                    $class = match(strtolower($status->nama_status ?? '')) {
                                        'diajukan' => 'badge bg-warning text-white',
                                        'disetujui' => 'badge bg-success',
                                        'ditolak' => 'badge bg-danger',
                                        default => 'badge bg-secondary',
                                    };
                                @endphp


                                <div class="col-md-3 fw-bold">Status:</div>
                                <div class="col-7">
                                    @if ($status)
                                        <span class="{{ $class }}">{{ $status->nama_status }}</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak diketahui</span>
                                    @endif
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
                                        <button class="btn btn-primary btn-sm mb-2 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#mapCollapse{{ $db->id_survei }}">
                                            Tampilkan Peta
                                        </button>
                                        <div class="collapse" id="mapCollapse{{ $db->id_survei }}">
                                            <div id="map{{ $db->id_survei }}" style="width: 100%; height: 300px; border-radius: 10px;"></div>
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
                var mapContainerId = "map{{ $db->id_survei }}";

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