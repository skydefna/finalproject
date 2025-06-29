
@extends('content.02.menu_admin')

@section('title', 'Lain Mata')

@section('breadcrumbs')

@endsection

@section('content')
<div class="content mt-2">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Data Lapor Aduan Lain Mata</strong>
                <div class="d-flex align-items-center">
                    <ol type="button" class="breadcrumb rounded mb-1 mr-2">
                        <li><a href="{{ route('admin.beranda') }}">Beranda</a></li>
                    </ol>
                    <button type="button" class="btn btn-success rounded mb-1" data-toggle="modal" data-target="#modalTambahAduan">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>

            {{-- Modal Tambah Aduan --}}
            <div class="modal fade" id="modalTambahAduan" tabindex="-1" aria-labelledby="modalTambahAduanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.buat') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahAduanLabel">Tambah Laporan Aduan</h5>
                                <button type="button" class="btn btn-danger rounded" data-dismiss="modal">X</button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    {{-- Pilih Pengajuan --}}
                                    <div class="row form-group">
                                        <label for="pengajuan_id" class="col-md-3 text-md-left">Pengajuan</label>
                                        <div class="col col-md-8">
                                            <select name="pengajuan_id" id="pengajuan_id" class="form-control" required>
                                                <option value="">-- Pilih Pengajuan --</option>
                                                @foreach ($pengajuan as $p)
                                                    <option value="{{ $p->id_pengajuan }}">
                                                        {{ $p->nama_pic_lokasi }} - {{ $p->kontak_pic_lokasi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Pilih Lokasi --}}
                                    <div class="row form-group">
                                        <label for="lokasi_id" class="col-md-3 text-md-left">Lokasi</label>
                                        <div class="col col-md-8">
                                            <select name="lokasi_id" id="lokasi_id" class="form-control" required>
                                                <option value="">-- Pilih Lokasi --</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div class="row form-group">
                                        <label for="deskripsi" class="col-md-3 text-md-left">Deskripsi</label>
                                        <div class="col col-md-8">
                                            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Upload Foto --}}
                                    <div class="row form-group">
                                        <label for="foto" class="col-md-3 text-md-left">Upload Foto</label>
                                        <div class="col col-md-8">
                                            <input type="file" name="foto" class="form-control-file" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="data-aduan-table" class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Pengajuan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aduan as $index => $a)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $a->lokasi->nama_lokasi ?? '-' }}</td>
                            <td>{{ $a->pengajuan->nama_pic_lokasi ?? '-' }}</td>
                            <td class="text-left">{{ $a->deskripsi }}</td>
                            <td>
                                <span class="badge 
                                    @if($a->statusaduan->nama_status_aduan == 'Menunggu') badge-warning
                                    @elseif($a->statusaduan->nama_status_aduan == 'Menuju Lokasi') badge-info
                                    @elseif($a->statusaduan->nama_status_aduan == 'Selesai') badge-success
                                    @else badge-secondary @endif">
                                    {{ $a->statusaduan->nama_status_aduan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($a->foto)
                                    <a href="{{ asset('storage/' . $a->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $a->foto) }}" alt="Foto" class="img-thumbnail" style="max-width: 80px;">
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>{{ $a->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Tombol Edit (Trigger Modal) --}}
                                    <button class="btn btn-sm btn-primary rounded mr-1" data-toggle="modal" data-target="#modalEditAduan{{ $a->id_aduan }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.delete', $a->id_aduan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aduan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit Aduan --}}
                        <div class="modal fade" id="modalEditAduan{{ $a->id_aduan }}" tabindex="-1" aria-labelledby="modalEditAduanLabel{{ $a->id_aduan }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.edit', $a->id_aduan) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditAduanLabel{{ $a->id_aduan }}">Edit Laporan Aduan</h5>
                                            <button type="button" class="btn btn-danger rounded" data-dismiss="modal">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                {{-- Pilih Pengajuan --}}
                                                <div class="row form-group">
                                                    <label for="pengajuan_id" class="col-md-3 text-md-left">Pengajuan</label>
                                                    <div class="col col-md-8">
                                                        <select class="form-control" disabled>
                                                            <option value="">-- Pilih Pengajuan --</option>
                                                            @foreach ($pengajuan as $p)
                                                                <option value="{{ $p->id_pengajuan }}"
                                                                    {{ old('pengajuan_id', $a->pengajuan_id) == $p->id_pengajuan ? 'selected' : '' }}>
                                                                    {{ $p->nama_pic_lokasi }} - {{ $p->kontak_pic_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Pilih Lokasi --}}
                                                <div class="row form-group">
                                                    <label for="lokasi_id" class="col-md-3 text-md-left">Lokasi</label>
                                                    <div class="col col-md-8">
                                                        <select class="form-control" disabled>
                                                            <option value="">-- Pilih Lokasi --</option>
                                                            @foreach ($lokasi as $l)
                                                                <option value="{{ $l->id_lokasi }}"
                                                                    {{ old('lokasi_id', $a->lokasi_id) == $l->id_lokasi ? 'selected' : '' }}>
                                                                    {{ $l->nama_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Deskripsi --}}
                                                <div class="row form-group">
                                                    <label for="deskripsi" class="col-md-3 text-md-left">Deskripsi</label>
                                                    <div class="col col-md-8">
                                                        <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $a->deskripsi) }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Foto Baru --}}
                                                <div class="row form-group">
                                                    <label for="foto" class="col-md-3 text-md-left">Foto Baru (Opsional)</label>
                                                    <div class="col col-md-8">
                                                        <input type="file" name="foto" class="form-control-file">
                                                        @if($a->foto)
                                                            <small>Foto saat ini: <a href="{{ asset('storage/' . $a->foto) }}" target="_blank">Lihat</a></small>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

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
    document.addEventListener('DOMContentLoaded', function () {
        const pengajuanSelect = document.getElementById('pengajuan_id');
        const lokasiSelect = document.getElementById('lokasi_id');

        pengajuanSelect.addEventListener('change', function () {
            const pengajuanId = this.value;
            console.log("Pengajuan dipilih ID:", pengajuanId); // Tambahkan ini

            lokasiSelect.innerHTML = '<option value="">-- Mengambil lokasi... --</option>';

            fetch(`/get-lokasi-by-pengajuan/${pengajuanId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Status: " + response.status);
                    return response.json();
                })
                .then(data => {
                    console.log("Data lokasi diterima:", data); // Tambahkan ini
                    lokasiSelect.innerHTML = '<option value="">-- Pilih Lokasi --</option>';
                    data.forEach(lokasi => {
                        const option = document.createElement('option');
                        option.value = lokasi.id_lokasi;
                        option.text = lokasi.nama_lokasi;
                        lokasiSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Gagal mengambil lokasi:", error); // Tambahkan ini
                    lokasiSelect.innerHTML = '<option value="">-- Gagal memuat lokasi --</option>';
                });
        });
    });

    $(document).ready(function() {
            var table = $('#data-aduan-table').DataTable({
                responsive: true,
                columnDefs: [
                    { targets: 4, width: "170px" }, // Status
                    { targets: 7, width: "30px" }  // Aksi
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
@endsection