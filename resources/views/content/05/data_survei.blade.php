
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
                    <button type="button" class="btn btn-success rounded mb-1" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="bootstrap-data-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center; vertical-align: middle;">No</th>
                            <th style="text-align:center; vertical-align: middle;">Nama Surveyor</th>
                            <th style="text-align:center; vertical-align: middle;">Nama PIC Lokasi</th>
                            <th style="text-align:center; vertical-align: middle;">Nama Lokasi</th>
                            <th style="text-align:center; vertical-align: middle;">Kecamatan</th>
                            <th style="text-align:center; vertical-align: middle;">Desa / Kelurahan</th>
                            <th style="text-align:center; vertical-align: middle;">Tanggal Survei</th>
                            <th style="text-align:center; vertical-align: middle;">Status</th>
                            <th class="d-none" style="text-align:center; vertical-align: middle;">Status Value</th>
                            <th>Aksi</th>                                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($survei as $id=>$db)
                            <tr>
                                <td style="vertical-align: middle">{{ $id+1 }}</td>
                                <td style="vertical-align: middle">{{ $db->nama_surveyor }}</td>
                                <td style="vertical-align: middle">{{ $db->pengajuan->nama_pic_lokasi }}</td>
                                <td style="text-align:center; vertical-align: middle;">
                                    {{ $db->lokasi->nama_lokasi ?? '-' }}
                                </td>
                                <td style="vertical-align: middle;">
                                    {{ $db->pengajuan->kecamatan->nama_kecamatan ?? '-' }}
                                </td>
                                <td style="vertical-align: middle;">
                                    {{ $db->pengajuan->desakelurahan->nama_desa_kelurahan ?? '-' }}
                                </td>
                                <td style="text-align:center; vertical-align: middle;">{{ $db->tanggal_survei }}</td>
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
                                <td style="text-align:center; vertical-align: middle;">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_survei }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-primary rounded btn-sm" data-toggle="modal" data-target="#editModal{{ $db->id_survei }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('survei.hapus', $db->id_survei) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="d-none">{{ $statusName ?? '' }}</td>
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
                                { "orderable": false, "targets": [7] } 
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Survei Lain Mata</h5>
                    <button type="button" class="btn btn-danger rounded" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('survei.create') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid">
                            <div class="row form-group">
                                <label for="nama_surveyor" class="col-md-3 text-md-left">Nama Surveyor</label>
                                <div class="col col-md-8">
                                    <input name="nama_surveyor" type="text" id="nama_surveyor" class="form-control @error ('nama_surveyor') is-invalid @enderror" value="{{ old('nama_surveyor') }}" autofocus placeholder="Bisa dibuat lebih dari 2: Dani, Dano, dan Dina">
                                    @error('nama_surveyor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="pengajuan_id" class="col-md-3 text-md-left">Pilih Pengajuan</label>
                                <div class="col col-md-8">
                                    <select name="pengajuan_id" id="pengajuan_id" class="form-control" onchange="loadDataPengajuan(this.value)">
                                        <option value="">-- Pilih Pengajuan --</option>
                                        @foreach ($pengajuanList as $pengajuan)
                                            <option value="{{ $pengajuan->id_pengajuan }}">{{ $pengajuan->nama_pic_lokasi }} - {{ $pengajuan->status->first()?->nama_status ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row form-group">
                                <label for="nama_lokasi" class="col-md-3 text-md-left">Nama Lokasi</label>
                                <div class="col col-md-8">
                                    <input name="nama_lokasi" type="text" id="nama_lokasi" class="form-control @error ('nama_lokasi') is-invalid @enderror" value="{{ old('nama_lokasi') }}" placeholder="Misal: Nama Sekolah..." readonly>
                                    @error('nama_lokasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="alamat_aktual" class="col-md-3 text-md-left">Alamat Aktual</label>
                                <div class="col col-md-8">
                                    <input name="alamat_aktual" type="text" id="alamat_aktual" class="form-control @error ('alamat_aktual') is-invalid @enderror" value="{{ old('alamat_aktual') }}" autofocus placeholder="Alamat lengkap yang diajukan" readonly>
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
                                    <input type="text" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" placeholder="Latitude" readonly>
                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-4">
                                    <input type="text" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" placeholder="Longitude" readonly>
                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="kecamatan_id" class="col-md-3 text-md-left">Kecamatan</label>
                                <div class="col col-md-8">
                                    <input type="text" name="kecamatan_id" id="kecamatan_id" class="form-control @error('kecamatan_id') is-invalid @enderror" value="{{ old('kecamatan_id') }}" placeholder="-" readonly>
                                    @error('kecamatan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="desa_kelurahan_id" class="col-md-3 text-md-left">Desa/Kelurahan</label>
                                <div class="col col-md-8">
                                    <input type="text" name="desa_kelurahan_id" id="desa_kelurahan_id" class="form-control @error('desa_kelurahan_id') is-invalid @enderror" value="{{ old('desa_kelurahan_id') }}" placeholder="-" readonly>
                                    @error('desa_kelurahan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="kontak_pic_lokasi" class="col-md-3 text-md-left">Nomor Kontak</label>
                                <div class="col col-md-8">
                                    <input type="text" name="kontak_pic_lokasi" id="kontak_pic_lokasi" class="form-control @error('kontak_pic_lokasi') is-invalid @enderror" value="{{ old('kontak_pic_lokasi') }}" placeholder="Nomor pengusul yang aktif: WhatsApp" readonly>
                                    @error('kontak_pic_lokasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="deskripsi" class="col-md-3 text-md-left">Deskripsi</label>
                                <div class="col col-md-8">
                                    <textarea name="deskripsi" 
                                            class="form-control @error('deskripsi') is-invalid @enderror" 
                                            rows="3" 
                                            placeholder="Keterangan untuk dilakukan pemasangan">{{ old('deskripsi') }}</textarea>
                                    
                                    @error('deskripsi')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="tanggal_survei" class="col-md-3 text-md-left">Tanggal survei</label>
                                <div class="col col-md-8">
                                    <input type="date" name="tanggal_survei" id="tanggal_survei" class="form-control @error('tanggal_survei') is-invalid @enderror" value="{{ old('tanggal_survei') }}">
                                    @error('tanggal_survei')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="foto" class="col-md-3 text-md-left">Upload Foto</label>
                                <div class="col col-md-8">
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
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

        <script>
            function loadDataPengajuan(id) {
                if (!id) return;

                fetch(`/pengajuan/data/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data:', data);

                        document.getElementById('nama_lokasi').value = data.nama_lokasi || '';
                        document.getElementById('alamat_aktual').value = data.alamat_aktual || '';
                        document.getElementById('kontak_pic_lokasi').value = data.kontak_pic_lokasi || '';
                        document.getElementById('latitude').value = data.latitude || '';
                        document.getElementById('longitude').value = data.longitude || '';
                        document.getElementById('kecamatan_id').value = data.nama_kecamatan || '-';
                        document.getElementById('desa_kelurahan_id').value = data.nama_desa || '-';
                    })
                    .catch(error => {
                        console.error('Gagal memuat data:', error);
                    });
            }

            document.addEventListener('DOMContentLoaded', function () {
                @if ($errors->any())
                    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                @endif
            });
        </script>
    </div>

    @foreach ($survei as $db)
        <div class="modal fade" id="editModal{{ $db->id_survei }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Survei Lain Mata</h5>
                        <button type="button" class="btn btn-danger rounded" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('survei.edit', $db->id_survei) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="container-fluid">
                                <div class="row form-group">
                                    <label for="nama_surveyor" class="col-md-3 text-md-left">Nama Surveyor</label>
                                    <div class="col col-md-8">
                                        <input name="nama_surveyor" type="text" id="nama_surveyor" class="form-control @error ('nama_surveyor') is-invalid @enderror" value="{{ old('nama_surveyor', $db->nama_surveyor) }}" autofocus placeholder="Bisa dibuat lebih dari 2: Dani, Dano, dan Dina">
                                        @error('nama_surveyor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="pengajuan_id_display" class="col-md-3 text-md-left">Pilih Pengajuan</label>
                                    <div class="col col-md-8">
                                        <select id="pengajuan_id_display" class="form-control" disabled>
                                            <option value="">-- Pilih Pengajuan --</option>
                                            @foreach ($pengajuanList as $pengajuan)
                                                <option value="{{ $pengajuan->id_pengajuan }}"
                                                    {{ old('pengajuan_id', $db->pengajuan_id) == $pengajuan->id_pengajuan ? 'selected' : '' }}>
                                                    {{ $pengajuan->nama_pic_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- Hidden input agar tetap terkirim --}}
                                        <input type="hidden" name="pengajuan_id" value="{{ old('pengajuan_id') }}">
                                    </div>
                                </div>

                                {{-- Nama Lokasi --}}
                                <div class="row form-group">
                                    <label for="nama_lokasi" class="col-md-3 text-md-left">Nama Lokasi</label>
                                    <div class="col col-md-8">
                                        <input type="text" id="nama_lokasi_display" class="form-control" value="{{ old('nama_lokasi', $db->lokasi->nama_lokasi) }}" readonly disabled>                                        
                                    </div>
                                </div>

                                {{-- Alamat Aktual --}}
                                <div class="row form-group">
                                    <label for="alamat_aktual" class="col-md-3 text-md-left">Alamat Aktual</label>
                                    <div class="col col-md-8">
                                        <input type="text" id="alamat_aktual_display" class="form-control" value="{{ old('alamat_aktual', $db->pengajuan->alamat_aktual) }}" readonly disabled>                                    
                                    </div>
                                </div>

                                {{-- Kecamatan --}}
                                <div class="row form-group">
                                    <label for="kecamatan_id" class="col-md-3 text-md-left">Kecamatan</label>
                                    <div class="col col-md-8">
                                        <input type="text" id="kecamatan_display" class="form-control" value="{{ old('kecamatan_id', $db->pengajuan->kecamatan->nama_kecamatan) }}" readonly disabled>
                                    </div>
                                </div>

                                {{-- Desa/Kelurahan --}}
                                <div class="row form-group">
                                    <label for="desa_kelurahan_id" class="col-md-3 text-md-left">Desa/Kelurahan</label>
                                    <div class="col col-md-8">
                                        <input type="text" id="desa_display" class="form-control" value="{{ old('desa_kelurahan_id', $db->pengajuan->desakelurahan->nama_desa_kelurahan) }}" readonly disabled>
                                        <input type="hidden" name="desa_kelurahan_id" value="{{ old('desa_kelurahan_id') }}">
                                    </div>
                                </div>

                                {{-- Kontak --}}
                                <div class="row form-group">
                                    <label for="kontak_pic_lokasi" class="col-md-3 text-md-left">Nomor Kontak</label>
                                    <div class="col col-md-8">
                                        <input type="text" id="kontak_display" class="form-control" value="{{ old('kontak_pic_lokasi', $db->pengajuan->kontak_pic_lokasi) }}" readonly disabled>
                                        <input type="hidden" name="kontak_pic_lokasi" value="{{ old('kontak_pic_lokasi') }}">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="deskripsi" class="col-md-3 text-md-left">Deskripsi</label>
                                    <div class="col col-md-8">
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" required placeholder="Keterangan di untuk dilakukan pemasangan ">{{ old('deskripsi', $db->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="tanggal_survei" class="col-md-3 text-md-left">Tanggal survei</label>
                                    <div class="col col-md-8">
                                        <input type="date" name="tanggal_survei" id="tanggal_survei" class="form-control @error('tanggal_survei') is-invalid @enderror" value="{{ old('tanggal_survei', $db->tanggal_survei) }}">
                                        @error('tanggal_survei')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="foto" class="col-md-3 text-md-left">Foto Baru (Opsional)</label>
                                    <div class="col col-md-8">
                                        <input type="file" name="foto" class="form-control-file">
                                        @if($db->foto)
                                            <small>Foto saat ini: <a href="{{ asset('storage/' . $db->foto) }}" target="_blank">Lihat</a></small>
                                        @endif
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