
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
                <strong>Data Pengajuan</strong>
                <div class="d-flex align-items-center">
                    <ol type="button" class="breadcrumb rounded mb-1 mr-2">
                        <li><a href="{{ route('pimpinan.beranda') }}">Beranda</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">            
                        <table id="bootstrap-data-table" class="table table-bordered w-100">
                            <thead>
                                <tr style="text-align:center;">
                                    <th>No</th>
                                    <th>Nama PIC Lokasi</th>
                                    <th>Pengusul</th>
                                    <th>Nama Lokasi</th>
                                    <th>Kecamatan</th>
                                    <th>Desa / Kelurahan</th>
                                    <th>Kategori</th>
                                    <th>Kontak PIC</th>
                                    <th>Status</th>
                                    <th>Status Aktif</th>
                                    <th class="d-none">Status Aktif Value</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuan as $id=>$db)
                                    @php
                                        $statusLast = $db->status->last();
                                        $statusName = $statusLast ? $statusLast->nama_status : '';
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: middle">{{ $id+1 }}</td>
                                        <td class="align-middle">{{ $db->nama_pic_lokasi }}</td>
                                        <td class="align-middle text-center">{{ $db->pengusul }}</td>
                                        <td style="vertical-align: middle">
                                            @foreach ($db->lokasi as $lok)
                                                {{ $lok->nama_lokasi }}<br>
                                            @endforeach
                                        </td>
                                        <td style="vertical-align: middle">{{ $db->kecamatan->nama_kecamatan }}</td>
                                        <td style="vertical-align: middle">{{ $db->desakelurahan->nama_desa_kelurahan }}</td>
                                        <td style="vertical-align: middle">{{ $db->Kategori->nama_kategori }}</td>
                                        <td style="vertical-align: middle">{{ $db->kontak_pic_lokasi }}</td>
                                        <td style="text-align:center; vertical-align: middle;">
                                            @php
                                                $latestStatus = $db->status->last();
                                                $class = match(strtolower($latestStatus->nama_status)) {
                                                    'diajukan' => 'badge bg-warning text-white',
                                                    'disetujui' => 'badge bg-success',
                                                    'ditolak' => 'badge bg-danger',
                                                    default => 'badge bg-secondary',
                                                };
                                            @endphp

                                            @if ($latestStatus)
                                                <span class="{{ $class }}">{{ $latestStatus->nama_status }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center; vertical-align: middle;">
                                            @if($db->status_on == 1)
                                                Aktif
                                            @else
                                                Mati
                                            @endif
                                        </td>
                                        <td style="display: none;">
                                            {{ $db->status_on }}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <button class="btn btn-info rounded btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_pengajuan }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan JS DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#bootstrap-data-table').DataTable({
                responsive: true,
                columnDefs: [
                    { targets: 8, width: "170px" }, // Status
                    { targets: 9, width: "30px" }  // Aksi
                ],
                language: {
                    emptyTable: "Data Belum Dibuat",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    zeroRecords: "Tidak ada data ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                }
            });

            $('#tabel-pimpinan tbody tr').each(function () {
                console.log('Jumlah kolom di baris ini:', $(this).find('td').length);
            });
        });
    </script>

    @foreach ($pengajuan as $db)
        <div class="modal fade" id="modalReview{{ $db->id_pengajuan }}" tabindex="-1" aria-labelledby="modalLabel{{ $db->id_pengajuan }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $db->id_pengajuan }}">Detail Usulan: {{ $db->pengguna->username }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body" style="border-radius: 50px;">
                        <div class="container">
                            @php
                                $lokasiUtama = $db->lokasi[0] ?? null;
                                $waNumber = preg_replace('/^0/', '62', $db->kontak_pic_lokasi);
                                $linkWhatsapp = "https://wa.me/$waNumber";
                            @endphp

                            {{-- Informasi Utama --}}
                            <div class="row mb-3 border-bottom pb-2">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-5"><strong>Nama PIC Lokasi</strong></div>
                                        <div class="col-7">{{ $db->nama_pic_lokasi }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5"><strong>Pengusul</strong></div>
                                        <div class="col-7">{{ $db->pengusul }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5"><strong>Kategori:</strong></div>
                                        <div class="col-7">{{ $db->kategori->nama_kategori }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5"><strong>Tgl Usul:</strong></div>
                                        <div class="col-7">{{ $db->tanggal_usul }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-5"><strong>Kecamatan:</strong></div>
                                        <div class="col-7">{{ $db->kecamatan->nama_kecamatan }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5"><strong>Desa/Kel.:</strong></div>
                                        <div class="col-7">{{ $db->desakelurahan->nama_desa_kelurahan }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5"><strong>Alamat:</strong></div>
                                        <div class="col-7">{{ $db->alamat_aktual }}</div>
                                    </div>
                                </div>
                            </div>

                            
                            
                            <div class="row mb-2 border-bottom pb-2">
                                @php
                                    $latestStatus = $db->status->last();
                                    $class = match(strtolower($latestStatus->nama_status)) {
                                        'diajukan' => 'badge bg-warning text-white',
                                        'disetujui' => 'badge bg-success',
                                        'ditolak' => 'badge bg-danger',
                                        default => 'badge bg-secondary',
                                    };

                                    $statusAktif = $db->status_on == 1 ? 'Aktif' : 'Mati';
                                    $statusAktifClass = $db->status_on == 1 ? 'text-success fw-bold' : 'text-danger fw-bold';
                                @endphp

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-5"><strong>Status:</strong></div>
                                        <div class="col-7">
                                            @if ($latestStatus)
                                                <span class="{{ $class }}">{{ $latestStatus->nama_status }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-5"><strong>Status Aktif:</strong></div>
                                        <div class="col-7">
                                            <span class="{{ $statusAktifClass }}">{{ $statusAktif }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Lokasi --}}
                            @if ($db->lokasi->count())
                                <div class="row mb-2 border-bottom pb-1">
                                    <div class="col-md-3 fw-bold text-left">Lokasi:</div>
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

                                {{-- Peta --}}
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
                                </script>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach 
</div>
@endsection