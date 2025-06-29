
@extends('content.05.menu_akun')

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
                        <li><a href="{{ route('akun.keseluruhan.tabel') }}">Beranda</a></li>
                    </ol>
                    <button type="button" class="btn btn-success rounded mb-1" data-toggle="modal" data-target="#modalTambahAduan">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
            
            <div class="card-body table-responsive">
                <table id="data-aduan-table" class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Pengajuan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aduan as $index => $db)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $db->lokasi->nama_lokasi ?? '-' }}</td>
                                <td>{{ $db->pengajuan->nama_pic_lokasi ?? '-' }}</td>
                                <td class="text-left">{{ $db->deskripsi }}</td>
                                <td>
                                    <span class="badge 
                                        @if($db->statusaduan->nama_status_aduan == 'Menunggu') badge-warning
                                        @elseif($db->statusaduan->nama_status_aduan == 'Menuju Lokasi') badge-info
                                        @elseif($db->statusaduan->nama_status_aduan == 'Selesai') badge-success
                                        @else badge-secondary @endif">
                                        {{ $db->statusaduan->nama_status_aduan ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $db->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-info btn-sm rounded mr-1" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_aduan }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary rounded mr-1" data-toggle="modal" data-target="#modalEditAduan{{ $db->id_aduan }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('aduan.delete', $db->id_aduan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aduan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded mr-1"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($aduan as $db)
        {{-- Modal Tambah Aduan --}}
        <div class="modal fade" id="modalTambahAduan" tabindex="-1" aria-labelledby="modalTambahAduanLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('aduan.buat') }}" enctype="multipart/form-data">
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
                                                    {{ $p->kecamatan->nama_kecamatan }} - {{ $p->nama_pic_lokasi }} - {{ $p->kontak_pic_lokasi }}
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

        {{-- Modal Review Aduan --}}
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
                                    <div class="d-flex mb-2">
                                        <div class="fw-bold me-2" style="min-width: 150px;">Kontak:</div>
                                        <div>
                                            <a href="{{ $linkWhatsapp }}" target="_blank" class="text-success text-decoration-none">
                                                <i class="fab fa-whatsapp"></i> {{ $db->pengajuan->kontak_pic_lokasi ?? '-' }}
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
                                        <div class="fw-bold me-2" style="min-width: 180px;">Status Aduan:</div>
                                        <div>
                                            <span class="badge 
                                                @if($db->statusaduan->nama_status_aduan == 'Menunggu') badge-warning
                                                @elseif($db->statusaduan->nama_status_aduan == 'Menuju Lokasi') badge-info
                                                @elseif($db->statusaduan->nama_status_aduan == 'Selesai') badge-success
                                                @else badge-secondary @endif">
                                                {{ $db->statusaduan->nama_status_aduan ?? '-' }}
                                            </span>
                                        </div>
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
        </div>

        {{-- Modal Edit Aduan --}}
        <div class="modal fade" id="modalEditAduan{{ $db->id_aduan }}" tabindex="-1" aria-labelledby="modalEditAduanLabel{{ $db->id_aduan }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('aduan.edit', $db->id_aduan) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditAduanLabel{{ $db->id_aduan }}">Edit Laporan Aduan</h5>
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
                                                    {{ old('pengajuan_id', $db->pengajuan_id) == $p->id_pengajuan ? 'selected' : '' }}>
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
                                                    {{ old('lokasi_id', $db->lokasi_id) == $l->id_lokasi ? 'selected' : '' }}>
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
                                        <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $db->deskripsi) }}</textarea>
                                    </div>
                                </div>

                                {{-- Foto Baru --}}
                                <div class="row form-group">
                                    <label for="foto" class="col-md-3 text-md-left">Foto Baru (Opsional)</label>
                                    <div class="col col-md-8">
                                        <input type="file" name="foto" class="form-control-file">
                                        @if($db->foto)
                                            <small>Foto saat ini: <a href="{{ asset('storage/' . $db->foto) }}" target="_blank">Lihat</a></small>
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

    @endforeach  
    <script>
        document.getElementById('pengajuan_id').addEventListener('change', function() {
            const pengajuanId = this.value;
            const lokasiSelect = document.getElementById('lokasi_id');

            lokasiSelect.innerHTML = '<option value="">Memuat lokasi...</option>';

            if (!pengajuanId) {
                lokasiSelect.innerHTML = '<option value="">-- Pilih Lokasi --</option>';
                return;
            }

            fetch(`/lokasi/by-pengajuan/${pengajuanId}`)
                .then(response => response.json())
                .then(data => {
                    lokasiSelect.innerHTML = '<option value="">-- Pilih Lokasi --</option>';
                    data.forEach(l => {
                        lokasiSelect.innerHTML += `<option value="${l.id_lokasi}">
                            ${l.nama_lokasi}
                        </option>`;
                    });
                })
                .catch(err => {
                    lokasiSelect.innerHTML = '<option value="">Gagal memuat lokasi</option>';
                    console.error(err);
                });
        });

        $(document).ready(function() {
            var table = $('#data-aduan-table').DataTable({
                responsive: true,
                columnDefs: [
                    { targets: 4, width: "170px" }, // Status
                    { targets: 6, width: "30px" }  // Aksi
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

</div>
@endsection