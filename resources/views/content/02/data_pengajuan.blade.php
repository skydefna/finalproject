
@extends('content.02.menu_admin')

@section('title', 'Lain Mata')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Pengajuan Lain Mata</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="{{ route('admin.beranda') }}">Beranda</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content mt-2">
    <div class="card-body table-responsive">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <div class="form-group">
                <label for="filter-status" class="form-label">Filter Status:</label>
                <select id="filter-status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Diajukan">Diajukan</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                    <!-- tambahkan status lain jika perlu -->
                </select>
            </div>

            <form action="{{ route('pengajuan.export') }}" method="GET">
                <input type="hidden" name="status" id="export-status">
                <button type="submit" class="btn btn-success btn-sm mt-2">Export Excel</button>
            </form>
        </div>
        <table id="data-pengajuan" class="table table-bordered">
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
                    <th style="min-width: 120px;">Status Aktif</th>
                    <th class="d-none">Status Aktif Value</th>
                    <th>Aksi</th>
                    <th class="d-none">Status Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuan as $id=>$db)
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
                        <td style="vertical-align: middle; text-align: center; min-width: 120px;">
                            <span style="display: none;">{{ $db->status_on ? 'On' : 'Off' }}</span>
                            <form action="{{ route('admin.toggleStatus', $db->id_pengajuan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status_on" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="1" {{ $db->status_on ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ !$db->status_on ? 'selected' : '' }}>Mati</option>
                                </select>
                            </form>
                        </td>
                        <td style="display: none;">
                            {{ $db->status_on }}
                        </td>

                        <td style="vertical-align: middle; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 5px;">
                                <button class="btn btn-info rounded btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_pengajuan }}">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-primary rounded btn-sm" data-toggle="modal" data-target="#editModal{{ $db->id_pengajuan }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.hapus', $db->id_pengajuan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td style="display: none;">
                            {{ optional($db->status->last())->nama_status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                const table = $('#data-pengajuan').DataTable({
                    pageLength: 5,
                    lengthMenu: [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ], 
                    columnDefs: [
                        { targets: 8, width: "100px" }, // Status
                        { targets: 11, width: "120px" }, // Aksi
                        { targets: 10, visible: false }, // Status Aktif Value (hidden)
                        { targets: 12, visible: false }, // Status Value (hidden)
                        {
                        targets: 9, // Status Aktif
                        searchable: true,
                        render: function (data, type, row, meta) {
                            if (type === 'display') {
                                return data; // tampilkan dropdown seperti aslinya
                            } else {
                                // untuk pencarian/filter, ambil isi dari <span>
                                const div = document.createElement("div");
                                div.innerHTML = data;
                                const hiddenSpan = div.querySelector("span");
                                return hiddenSpan ? hiddenSpan.textContent.trim() : '';
                            }
                        }
                    }
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

                $('#filter-status').on('change', function () {
                    const selected = $(this).val();
                    $('#export-status').val(selected); // set input hidden untuk form export

                    if (selected) {
                        table.column(12).search(selected).draw();
                    } else {
                        table.column(12).search('').draw();
                    }
                });
            });
        </script>

        @foreach ($pengajuan as $db)
            <div class="modal fade" id="editModal{{ $db->id_pengajuan }}" tabindex="-1" aria-labelledby="editModalLabel{{ $db->id_pengajuan }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pengajuan</h5>
                            <button type="button" class="btn btn-danger rounded" data-dismiss="modal">X</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.update', $db->id_pengajuan) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="container-fluid">
                                    <div class="row form-group">
                                        <label for="pengguna_id" class="col-md-3 text-md-left">Nama Pengguna</label>
                                        <div class="col col-md-8">
                                            {{-- Tampilkan nama pengguna (tidak bisa diedit) --}}
                                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>

                                            {{-- Kirim ID pengguna secara tersembunyi --}}
                                            <input type="hidden" name="pengguna_id" id="pengguna_id" value="{{ $user->id_pengguna }}">

                                            @error('pengguna_id')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="row form-group">
                                        <label for="nama_pic_lokasi" class="col-md-3 text-md-left">Nama PIC Lokasi</label>
                                        <div class="col col-md-8">
                                            <input name="nama_pic_lokasi" type="text" id="nama_pic_lokasi" class="form-control @error ('nama_pic_lokasi') is-invalid @enderror" 
                                            value="{{ old('nama_pic_lokasi', $db->nama_pic_lokasi) }}" autofocus placeholder="Nama yang bertanggung jawab">
                                            @error('nama_pic_lokasi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="pengusul" class="col-md-3 text-md-left">Pengusul</label>
                                        <div class="col col-md-8">
                                            <input name="pengusul" type="text" id="pengusul" class="form-control @error ('pengusul') is-invalid @enderror" 
                                            value="{{ old('pengusul', $db->pengusul) }}" autofocus placeholder="Dinas yang bertanggung jawab">
                                            @error('pengusul')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <label for="nama_lokasi" class="col-md-3 text-md-left">Nama Lokasi</label>
                                        <div class="col col-md-8">
                                            <input name="nama_lokasi" type="text" id="nama_lokasi" class="form-control @error ('nama_lokasi') is-invalid @enderror" 
                                            value="{{ old('nama_lokasi', $db->lokasi->first()->nama_lokasi ?? '') }}" autofocus placeholder="Misal: Nama Sekolah, Nama Fasilitas Umum, dan Nama RTH"></div>
                                            @error('nama_lokasi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>

                                    <div class="row form-group">
                                        <label for="alamat_aktual" class="col-md-3 text-md-left">Alamat Aktual</label>
                                        <div class="col col-md-8">
                                            <input name="alamat_aktual" type="text" id="alamat_aktual" class="form-control @error ('alamat_aktual') is-invalid @enderror" 
                                            value="{{ old('alamat_aktual', $db->alamat_aktual) }}" autofocus placeholder="Alamat lengkap yang diajukan">
                                            @error('alamat_aktual')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>    
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-md-3 text-md-left">Koordinat Lokasi</label>

                                        <!-- Latitude dan Tombol di bawahnya -->
                                        <div class="col-md-4">
                                            <input type="text" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" 
                                            value="{{ old('latitude', $db->lokasi->first()->latitude ?? '') }}" placeholder="Latitude">
                                            @error('latitude')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary btn-sm rounded" onclick="getLocation()">Dapatkan Lokasi Saya</button>
                                                <small id="demo" class="form-text text-muted mt-1">Pastikan posisi berada di tempat yang diusulkan</small>
                                            </div>
                                        </div>

                                        <!-- Longitude -->
                                        <div class="col-md-4">
                                            <input type="text" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" 
                                            value="{{ old('longitude', $db->lokasi->first()->longitude ?? '') }}" placeholder="Longitude">
                                            @error('longitude')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <script>
                                        function getLocation() {
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition(
                                                    function(position) {
                                                        document.getElementById("latitude").value = position.coords.latitude;
                                                        document.getElementById("longitude").value = position.coords.longitude;
                                                        
                                                        // Notifikasi lokasi berhasil
                                                        document.getElementById("demo").innerText = "✅ Lokasi berhasil didapatkan.";
                                                    },
                                                    function(error) {
                                                        // Notifikasi lokasi gagal
                                                        document.getElementById("demo").innerText = "❌ Gagal mendeteksi lokasi. ";
                                                    }
                                                );
                                            } else {
                                                alert("Browser tidak mendukung Geolocation");
                                            }
                                        }

                                        // Ambil lokasi ketika modal ditampilkan (jika ada modal)
                                        $('#exampleModal').on('shown.bs.modal', function () {
                                            getLocation();
                                        });
                                    </script>

                                    <div class="row form-group">
                                        <label for="kecamatan_id" class="col-md-3 text-md-left">Pilih Kecamatan</label>
                                        <div class="col col-md-8">
                                            <select name="kecamatan_id" id="edit_kecamatan_id" class="form-control @error('kecamatan_id') is-invalid @enderror">
                                                @foreach ($kecamatan as $kec)
                                                <option value="{{ $kec->id_kecamatan }}"
                                                    {{ (old('kecamatan_id') ?? $db->kecamatan_id) == $kec->id_kecamatan ? 'selected' : '' }}>
                                                    {{ $kec->nama_kecamatan }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('kecamatan_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="desa_kelurahan_id" class="col-md-3 text-md-left">Pilih Desa/Kelurahan</label>
                                        <div class="col col-md-8">
                                            <select name="desa_kelurahan_id" id="edit_desa_kelurahan_id" class="form-control @error('desa_kelurahan_id') is-invalid @enderror">
                                                @foreach ($desa_kelurahan as $desa)
                                                    <option value="{{ $desa->id_desa_kelurahan }}"
                                                        {{ (old('desa_kelurahan_id') ?? $db->desa_kelurahan_id) == $desa->id_desa_kelurahan ? 'selected' : '' }}>
                                                        {{ $desa->nama_desa_kelurahan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('desa_kelurahan_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="kategori_id" class="col-md-3 text-md-left">Kategori Usulan</label>
                                        <div class="col col-md-8">
                                            <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                                @foreach ($kategori_usulan as $kategori)
                                                    <option value="{{ $kategori->id_kategori }}"
                                                        {{ (old('kategori_id', $db->kategori_id) == $kategori->id_kategori) ? 'selected' : '' }}>
                                                        {{ $kategori->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="kontak_pic_lokasi" class="col-md-3 text-md-left">Nomor Kontak</label>
                                        <div class="col col-md-8">
                                            <input type="text" name="kontak_pic_lokasi" id="kontak_pic_lokasi" class="form-control @error('kontak_pic_lokasi') is-invalid @enderror" 
                                            value="{{ old('kontak_pic_lokasi', $db->kontak_pic_lokasi) }}" placeholder="Nomor pengusul yang aktif: WhatsApp">
                                            @error('kontak_pic_lokasi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="tanggal_usul" class="col-md-3 text-md-left">Tanggal Usul</label>
                                        <div class="col col-md-8">
                                            <input type="date" name="tanggal_usul" id="tanggal_usul" class="form-control @error('tanggal_usul') is-invalid @enderror" 
                                            value="{{ old('tanggal_usul', $db->tanggal_usul) }}">
                                            @error('tanggal_usul')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success rounded">Simpan</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
                                        <div class="row">
                                            <div class="col-5"><strong>Kontak PIC:</strong></div>
                                            <div class="col-7">
                                                <a href="{{ $linkWhatsapp }}" target="_blank" class="text-decoration-none text-success">
                                                    <i class="fab fa-whatsapp me-1"></i> {{ $db->kontak_pic_lokasi }}
                                                </a>
                                            </div>
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
</div>
@endsection