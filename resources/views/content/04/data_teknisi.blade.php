
@extends('content.04.menu_teknisi')

@section('title', 'Lain Mata')

@section('breadcrumbs')

@endsection

@section('content')
<div class="content mt-3">
    @csrf
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Data Pemasangan Lain Mata</strong>
                <div class="d-flex align-items-center">
                    <ol type="button" class="breadcrumb rounded mb-1 mr-3">
                        <li><a href="{{ route('teknisi.beranda') }}">Beranda</a></li>
                    </ol>
                    <button type="button" class="btn btn-success rounded mb-1" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Lapangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('teknisi.submit') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="nama_petugas" class="col-md-3 col-form-label">Nama Petugas</label>
                            <div class="col-md-7">
                                <input type="text" name="nama_petugas" id="nama_petugas" class="form-control @error('nama_petugas') is-invalid @enderror" value="{{ old('nama_petugas') }}">
                                @error('nama_petugas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pengajuan_id" class="col-md-3 col-form-label">Nama PIC Lokasi</label>
                            <div class="col-md-7">
                                <select name="pengajuan_id" id="pengajuan_id" class="form-control @error('pengajuan_id') is-invalid @enderror" required>
                                    <option value="">Pilih PIC Pengusul...</option>
                                    @foreach ($pengajuan as $db)
                                        <option value="{{ $db->id_pengajuan }}" {{ old('pengajuan_id') == $db->id_pengajuan ? 'selected' : '' }}>
                                            {{ $db->nama_pic_lokasi }} - {{ $db->status->first()?->nama_status ?? 'Belum Disetujui' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pengajuan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lokasi_id" class="col-md-3 col-form-label">Nama Lokasi</label>
                            <div class="col-md-7">
                                <select name="lokasi_id" id="lokasi_id"
                                        class="form-control @error('lokasi_id') is-invalid @enderror"
                                        required disabled> 
                                    <option value="">Pilih Nama PIC terlebih dahulu</option>
                                </select>
                                @error('lokasi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ip_assigment" class="col-md-3 col-form-label">IP Assigment</label>
                            <div class="col-md-7">
                                <input type="text" name="ip_assigment" id="ip_assigment" class="form-control @error('ip_assigment') is-invalid @enderror" value="{{ old('ip_assigment') }}">
                                @error('ip_assigment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="provider_id" class="col-md-3 col-form-label">Tipe Koneksi</label>
                            <div class="col-md-7">
                                <select name="provider_id" id="provider_id" class="form-control @error('provider_id') is-invalid @enderror" required>
                                    <option value="">Pilih Koneksi...</option>
                                    @foreach ($provider as $pro)
                                        <option value="{{$pro->id_provider}}">{{$pro->nama_provider}}</option>
                                    @endforeach
                                </select>
                                @error('provider_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipe_alat" class="col-md-3 col-form-label">Tipe Alat</label>
                            <div class="col-md-7">
                                <input type="text" name="tipe_alat" id="tipe_alat" class="form-control @error('tipe_alat') is-invalid @enderror" value="{{ old('tipe_alat') }}">
                                @error('tipe_alat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_pemasangan" class="col-md-3 col-form-label">Tanggal Pemasangan</label>
                            <div class="col-md-7">
                                <input type="date" name="tanggal_pemasangan" id="tanggal_pemasangan" class="form-control @error('tanggal_pemasangan') is-invalid @enderror" value="{{ old('tanggal_pemasangan') }}" required>
                                @error('tanggal_pemasangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dokumentasi_pemasangan" class="col-md-3 col-form-label">Dokumentasi</label>
                            <div class="col-md-7">
                                <input type="file" name="dokumentasi_pemasangan[]" id="dokumentasi_pemasangan" class="form-control @error('dokumentasi_pemasangan') is-invalid @enderror" multiple accept="image/*">
                                <small id="file-chosen" class="text-muted">Belum ada file dipilih</small>
                                @error('dokumentasi_pemasangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('dokumentasi_pemasangan').addEventListener('change', function() {
                            const label = document.getElementById('file-chosen');
                            const files = this.files;
                            label.textContent = files.length > 0 ? Array.from(files).map(f => f.name).join(', ') : 'Belum ada file dipilih';
                        });

                         $(document).ready(function () {
                            $('#pengajuan_id').on('change', function () {
                                const pengajuanId = $(this).val();
                                const lokasiDropdown = $('#lokasi_id');

                                // Kosongkan dan nonaktifkan dulu
                                lokasiDropdown.html('<option value="">Memuat lokasi...</option>').prop('disabled', true);

                                // Kosongkan dan nonaktifkan dulu
                                $('#lokasi_id')
                                    .html('<option value="">Memuat lokasi...</option>')
                                    .prop('disabled', true);

                                if (pengajuanId) {
                                    $.ajax({
                                        url: '/teknisi/lokasi/' + pengajuanId,
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function (data) {         
                                            let options = '';
                                            if (data.length > 0) {
                                                options += '<option value="">Pilih Lokasi...</option>';
                                                data.forEach(function (lokasi) {
                                                    options += `<option value="${lokasi.id_lokasi}">${lokasi.nama_lokasi}</option>`;
                                                });
                                                lokasiDropdown.html(options).prop('disabled', false);
                                            } else {
                                                // Jika data kosong (pengajuan tidak disetujui atau tidak ada lokasi)
                                                options += '<option value="">Pengajuan belum disetujui atau tidak ada lokasi</option>';
                                                lokasiDropdown.html(options).prop('disabled', true);
                                            }
                                        },
                                        error: function () {
                                        // Ini akan terpanggil jika ada kesalahan server (misal: 500 Internal Server Error)
                                        lokasiDropdown.html('<option value="">Terjadi kesalahan saat memuat lokasi</option>').prop('disabled', true);
                                    }
                                });
                            } else {
                                // Jika tidak ada pengajuan yang dipilih
                                lokasiDropdown.html('<option value="">Pilih Nama PIC terlebih dahulu</option>').prop('disabled', true);
                            }
                        });
                    });
                    </script>

                </div>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table id="bootstrap-data-table" class="table table-bordered">
            <thead>
                <tr style="text-align:center;">
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Nama PIC Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Tipe Koneksi</th>
                    <th>Kecamatan</th>
                    <th>Desa / Kelurahan</th>
                    <th>Tanggal Pemasangan</th>
                    <th>Kontak PIC</th>
                    <th>Aksi</th>                                
                </tr>
            </thead>
            <tbody>
                @foreach ($pemasangan as $id=>$db)
                    <tr>
                        <td style="vertical-align: middle">{{ $id+1 }}</td>
                        <td style="vertical-align: middle">{{ $db->nama_petugas }}</td>
                        <td style="vertical-align: middle">{{ $db->pengajuan->nama_pic_lokasi }}</td>
                        <td style="text-align:center; vertical-align: middle;">
                            @foreach ($db->lokasi as $lok)
                                {{ $lok->nama_lokasi }}<br>
                            @endforeach
                        </td>                        
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
                        <td style="text-align:center; vertical-align: middle;">{{ $db->pengajuan->kontak_pic_lokasi }}</td>
                        <td style="text-align:center; vertical-align: middle;">
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-info btn-sm rounded" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_pemasangan }}">
                                    <i class="fa fa-eye"></i>
                                </button>                                
                                <button class="btn btn-primary btn-sm rounded" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $db->id_pemasangan }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('hapus.data', $db->id_pemasangan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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
                        { "orderable": false, "targets": [7] } // ✅ Kolom Aksi = kolom ke-8 (index 7)
                    ],
                    "language": {
                        "emptyTable": "Data Belum Dibuat",
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ entri",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        "paginate": {
                            "previous": "Sebelumnya",
                            "next": "Berikutnya"
                        }
                    }
                });
            });
        </script>
        @foreach ($pemasangan as $db)
        <div class="modal fade" id="modalEdit{{ $db->id_pemasangan }}" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('update.data', $db->id_pemasangan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Pemasangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Petugas</label>
                                <input type="text" name="nama_petugas" class="form-control" value="{{ $db->nama_petugas }}">
                            </div>
                            <div class="mb-3">
                                <label>IP Assignment</label>
                                <input type="text" name="ip_assigment" class="form-control" value="{{ $db->ip_assigment }}">
                            </div>
                            <div class="mb-3">
                                <label for="provider_id">Tipe Koneksi</label>
                                <select name="provider_id" class="form-control">
                                    @foreach ($provider as $prov)
                                        <option value="{{ $prov->id_provider }}"
                                            {{ $db->provider->first()->id_provider == $prov->id_provider ? 'selected' : '' }}>
                                            {{ $prov->nama_provider }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Tipe Alat</label>
                                <input type="text" name="tipe_alat" class="form-control" value="{{ $db->tipe_alat }}">
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Pemasangan</label>
                                <input type="date" name="tanggal_pemasangan" class="form-control" value="{{ $db->tanggal_pemasangan }}">
                            </div>
                            @if ($db->dokumentasi_pemasangan)
                                <div class="mb-3">
                                    <label>Dokumentasi Sebelumnya:</label>
                                    <div class="d-flex flex-wrap justify-content-center gap-3">
                                        @foreach (json_decode($db->dokumentasi_pemasangan) as $foto)
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Dokumentasi" width="500" class="img-thumbnail">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label>Ganti Dokumentasi (opsional)</label><br>

                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <!-- Tombol Custom -->
                                    <label for="dokInput" class="btn btn-outline-primary mb-0">Pilih Berkas</label>
                                    <input type="file" name="dokumentasi_pemasangan[]" id="dokInput" class="d-none" multiple>

                                    <!-- Container untuk daftar file -->
                                    <div id="fileList" class="d-flex flex-wrap gap-2">
                                        <span class="text-muted">Belum ada berkas yang dipilih.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalReview{{ $db->id_pemasangan }}" tabindex="-1" aria-labelledby="modalLabel{{ $db->id_pemasangan }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $db->id_pemasangan }}">Detail Usulan</h5>
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
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama Petugas:</div>
                                        <div>{{ $db->nama_petugas }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Nama Pengusul:</div>
                                        <div>{{ $db->pengajuan->nama_pic_lokasi }}</div>
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
                                        <div class="fw-bold me-2" style="min-width: 180px;">IP Assignment:</div>
                                        <div>{{ $db->ip_assigment }}</div>
                                    </div>
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

            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('dokInput');
                const fileList = document.getElementById('fileList');

                input.addEventListener('change', function () {
                    const files = Array.from(this.files);
                    fileList.innerHTML = '';

                    if (files.length === 0) {
                        fileList.innerHTML = '<span class="text-muted">Belum ada berkas yang dipilih.</span>';
                        return;
                    }

                    files.forEach(file => {
                        const fileTag = document.createElement('span');
                        fileTag.className = 'badge bg-secondary p-2';
                        fileTag.textContent = file.name;
                        fileList.appendChild(fileTag);
                    });
                });
            });

            </script>
    @endforeach
@endsection