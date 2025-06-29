<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Lain Mata</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">
  <link href="{{ asset('pengguna/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link href="{{ asset('pengguna/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/css/main.css') }}" rel="stylesheet">

  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body class="index-page">

    <header id="header" class="header">
        <div class="container-fluid d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center" style="width: 33%; padding-left: 30px;" >
            <a href="{{ route('tamu.beranda') }}">
            <h1 class="sitename">Lain Mata</h1>
            </a>
        </div>
        
        <div class="d-flex justify-content-center" style="width: 34%;" >
            <nav id="navmenu" class="navmenu" class="mx-auto">
            <ul>
                <li><a href="{{ route('tamu.beranda') }}">Beranda<br></a></li>
                <li><a href="{{ route('tamu.pengajuan') }}" class="active">Pengajuan</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>

        <div class="d-flex justify-content-end" style="width: 33%; padding-right: 30px;">
            <div class="dropdown position-relative">
                <a href="#" class="dropdown-toggle-user"><span>Hai, {{ auth()->user()->nama_pengguna }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul class="dropdown-menu-custom">
                    <li><span class="dropdown-item">{{ auth()->user()->nama_pengguna }}</span></li>

                    <li>
                        <a href="{{ route('tamu.profil') }}" class="dropdown-item">
                            <i class="bi bi-person-lines-fill me-1"></i> Data Pribadi
                        </a>
                    </li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-1"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        
        </div>
    </header>

    <main class="main">

        <div class="main-wrapper">

            <section class="facts section-bg" style="margin-bottom: 150px; overflow: visible; min-height: 70vh;">
                <div class="animated fadeIn">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Pengajuan Lain Mata</strong>
                            <button type="button" id="btnTambahSurat" class="btn btn-success mb-1 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan Pengajuan E-Lain Mata</h5>
                                <button type="button" class="btn btn-danger rounded" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <!-- ...modal header tetap sama... -->
                            <div class="modal-body">
                                <form method="post" action="{{ route('tamu.submit') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="container-fluid">

                                        <div class="row form-group mb-3">
                                            <label for="nama_pic_lokasi" class="col-md-3 text-md-left">Nama PIC Lokasi</label>
                                            <div class="col col-md-8">
                                                <input name="nama_pic_lokasi" type="text" id="nama_pic_lokasi" class="form-control @error ('nama_pic_lokasi') is-invalid @enderror" value="{{ old('nama_pic_lokasi') }}" autofocus placeholder="Nama yang bertanggung jawab">
                                                @error('nama_pic_lokasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="pengusul" class="col-md-3 text-md-left">Pengusul</label>
                                            <div class="col col-md-8">
                                                <input name="pengusul" type="text" id="pengusul" class="form-control @error ('pengusul') is-invalid @enderror" value="{{ old('pengusul') }}" autofocus placeholder="Dinas yang bertanggung jawab">
                                                @error('pengusul')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="nama_lokasi" class="col-md-3 text-md-left">Nama Lokasi</label>
                                            <div class="col col-md-8">
                                                <input name="nama_lokasi" type="text" id="nama_lokasi" class="form-control @error ('nama_lokasi') is-invalid @enderror" value="{{ old('nama_lokasi') }}" autofocus placeholder="Misal: Nama Sekolah, Nama Fasilitas Umum, dan Nama RTH">
                                                @error('nama_lokasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="alamat_aktual" class="col-md-3 text-md-left">Alamat Aktual</label>
                                            <div class="col col-md-8">
                                                <input name="alamat_aktual" type="text" id="alamat_aktual" class="form-control @error ('alamat_aktual') is-invalid @enderror" value="{{ old('alamat_aktual') }}" autofocus placeholder="Alamat lengkap yang diajukan">
                                                @error('alamat_aktual')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label class="col-md-3 col-form-label">Koordinat Lokasi</label>

                                            <div class="col-md-4">
                                                <input type="text" name="latitude" id="latitude"
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    value="{{ old('latitude') }}" placeholder="Latitude">
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" name="longitude" id="longitude"
                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                    value="{{ old('longitude') }}" placeholder="Longitude">
                                                @error('longitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-8 offset-md-3 d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-primary btn-sm rounded" onclick="getLocation()">Dapatkan Lokasi Saya</button>
                                                <small id="demo" class="form-text text-muted m-0">
                                                    Tekan tombol untuk mendeteksi lokasi dan pastikan berada di lokasi yang diusulkan.
                                                </small>
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="kecamatan_id" class="col-md-3 text-md-left">Pilih Kecamatan</label>
                                            <div class="col col-md-8">
                                                <select name="kecamatan_id" id="kecamatan_id" class="form-control @error('kecamatan_id') is-invalid @enderror">
                                                    <option value="">Pilih Kecamatan...</option>
                                                    @foreach ($kecamatan as $kec)
                                                        <option value="{{$kec->id_kecamatan}}">{{$kec->nama_kecamatan}}</option>
                                                    @endforeach
                                                </select>
                                                @error('kecamatan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="desa_kelurahan_id" class="col-md-3 text-md-left">Pilih Desa/Kelurahan</label>
                                            <div class="col col-md-8">
                                                <select name="desa_kelurahan_id" id="desa_kelurahan_id" class="form-control @error('desa_kelurahan_id') is-invalid @enderror">
                                                    <option value="">Pilih Desa/Kelurahan...</option>
                                                </select>
                                                @error('desa_kelurahan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="kategori_id" class="col-md-3 text-md-left">Kategori Usulan</label>
                                            <div class="col col-md-8">
                                                <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                                    <option value="">Pilih Kategori...</option>
                                                    @foreach ($kategori_usulan as $kategori)
                                                        <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                                    @endforeach
                                                </select>
                                                @error('kategori_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="kontak_pic_lokasi" class="col-md-3 text-md-left">Nomor Kontak</label>
                                            <div class="col col-md-8">
                                                <input type="text" name="kontak_pic_lokasi" id="kontak_pic_lokasi" class="form-control @error('kontak_pic_lokasi') is-invalid @enderror" value="{{ old('kontak_pic_lokasi') }}" placeholder="Nomor pengusul yang aktif: WhatsApp">
                                                @error('kontak_pic_lokasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group mb-3">
                                            <label for="tanggal_usul" class="col-md-3 text-md-left">Tanggal Usul</label>
                                            <div class="col col-md-8">
                                                <input type="date" name="tanggal_usul" id="tanggal_usul" class="form-control @error('tanggal_usul') is-invalid @enderror" value="{{ old('tanggal_usul') }}">
                                                @error('tanggal_usul')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success rounded">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <script>
                        window.onload = function () {
                            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                            modal.show();
                        };
                    </script>
                @endif

                <div class="content" style="margin-top: 20px; min-height: 350px;">
                    @csrf
                    <div class="card-body">
                        <!-- Judul dan Peta -->
                        <div class="text-center mb-4">
                            <h3 class="my-3">Peta Lokasi Pengajuan Kabupaten Tabalong</h3>
                            <div id="map" style="height: 400px; width: 80%;" class="mx-auto rounded shadow-sm"></div>
                        </div>

                        <!-- Tabel -->
                        <div style="overflow-x: auto;">
                            <table class="table table-bordered table-striped table-sm" style="min-width: 1000px;">  
                                <thead class="table-light">
                                    <tr class="text-center align-middle">
                                        <th>No</th>
                                        <th>Nama PIC Lokasi</th>
                                        <th>Pengusul</th>
                                        <th>Nama Lokasi</th>
                                        <th>Kecamatan</th>
                                        <th>Desa / Kelurahan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengajuan as $id => $db)
                                        <tr>
                                            <td class="align-middle text-center">{{ $id+1 }}</td>
                                            <td class="align-middle">{{ $db->nama_pic_lokasi }}</td>
                                            <td class="align-middle text-center">{{ $db->pengusul }}</td>
                                            <td class="align-middle text-center">
                                                @foreach ($db->lokasi as $lok)
                                                    {{ $lok->nama_lokasi }}<br>
                                                @endforeach
                                            </td>
                                            <td class="align-middle text-center">{{ $db->kecamatan->nama_kecamatan }}</td>
                                            <td class="align-middle text-center">{{ $db->desakelurahan->nama_desa_kelurahan }}</td>
                                            <td class="align-middle text-center">
                                                @php
                                                    $latestStatus = $db->status->last();
                                                    $class = match(strtolower($latestStatus->nama_status ?? '')) {
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
                                            <td class="align-middle text-center">
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalReview{{ $db->id_pengajuan }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data Belum Dibuat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                
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

                                            
                                            <div class="row mb-2 align-items-center border-bottom pb-2">
                                                <div class="col-md-3 fw-bold text-left">Status:</div>
                                                <div class="col-md-9">
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
                                                </div>
                                            </div>

                                            <div class="row mb-2 align-items-center border-bottom pb-2">
                                                <div class="col-md-3 fw-bold text-left">Kontak PIC:</div>
                                                <div class="col-md-9">
                                                    <a href="{{ $linkWhatsapp }}" target="_blank" class="text-success text-decoration-none">
                                                        <i class="fab fa-whatsapp"></i> {{ $db->kontak_pic_lokasi }}
                                                    </a>
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
            </section>
        </div>

       <section id="kontak" class="kontact section" style="background-color: #000; color: #fff; padding: 60px 0; margin-bottom: 30px;">
            <div class="container section-title" data-aos="fade-up">
                <h3 style="text-align: center; color: #fff;">KONTAK ADMIN</h3>
                <p style="text-align: center;">Jika ada ingin ditanyakan dan masalah pada LAIN MATA, silahkan hubungi nomor dibawah ini:</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle" style="background-color: #ffffff;">
                        <thead style="background-color: #198754; color: white;">
                            <tr>
                                <th>Nama Admin</th>
                                <th>No. Kontak</th>
                                <th>Kecamatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adminUsers as $admin)
                                @php
                                    $no_wa = preg_replace('/[^0-9]/', '', $admin->no_kontak);
                                    $no_wa = preg_replace('/^0/', '62', $no_wa);
                                @endphp
                                <tr>
                                    <td>{{ $admin->nama_pengguna }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ $no_wa }}" target="_blank" style="color: #25D366; text-decoration: none;">
                                            <i class="fab fa-whatsapp" style="color: #25D366; margin-right: 5px;"></i>
                                            {{ $admin->no_kontak ?? '-' }}
                                        </a>
                                    </td>
                                    <td>{{ $admin->kecamatan->nama_kecamatan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>

    <footer id="footer" class="footer light-background">

        <div class="container copyright text-center mt-8">
        <p><span>Copyright ©</span> <strong class="px-1 sitename">2025</strong> <span>Dinas Komunikasi dan Informatika</span></p>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="https://code.jquery.com/jquery-3.8.0.min.js"></script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById("latitude").value = position.coords.latitude;
                        document.getElementById("longitude").value = position.coords.longitude;

                        const demo = document.getElementById("demo");
                        demo.innerHTML = '<span style="color:green">&#x2705;</span> Lokasi berhasil didapatkan.';
                        demo.classList.remove("text-danger");
                        demo.classList.add("text-success");
                    },
                    function(error) {
                        const demo = document.getElementById("demo");
                        demo.innerHTML = '<span style="color:red">&#x274C;</span> Gagal mendeteksi lokasi.';
                        demo.classList.remove("text-success");
                        demo.classList.add("text-danger");
                    }
                );
            } else {
                alert("Browser tidak mendukung Geolocation");
            }
        }

        document.getElementById('kecamatan_id').addEventListener('change', function () {
            let kecamatanId = this.value;
            console.log('Kecamatan ID:', kecamatanId); // Debug kecamatan ID yang dipilih

            fetch(`/api/desakelurahan?kecamatan_id=${kecamatanId}`)
                .then(response => {
                    console.log('Response status:', response.status); // Debug status respons
                    return response.json();
                })
                .then(data => {
                    console.log('Data desa/kelurahan:', data); // Debug data yang diterima

                    let desaSelect = document.getElementById('desa_kelurahan_id');
                    desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

                    data.forEach(desa_kelurahan => {
                        let option = document.createElement('option');
                        option.value = desa_kelurahan.id_desa_kelurahan;
                        option.textContent = desa_kelurahan.nama_desa_kelurahan;
                        desaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Fetch error:', error)); // Debug error
        });

        var map = L.map('map').setView([-1.864, 115.980], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var markers = [];

            // Tampilkan batas wilayah Kabupaten Tabalong
            fetch("/geojson/Tabalong.json")
                .then(response => response.json())
                .then(data => {
                // Layer Kabupaten
                var tabalongLayer = L.geoJSON(data, {
                    filter: function (feature) {
                    return feature.properties && feature.properties.NAME_2 === "Tabalong";
                    },
                    style: {
                    color: "#000000",
                    weight: 2,
                    opacity: 0.8,
                    fillOpacity: 0.05,
                    fillColor: "#66b2ff"
                    },
                    onEachFeature: function (feature, layer) {
                    layer.bindPopup("Kabupaten: " + feature.properties.NAME_2);
                    }
                }).addTo(map);

                // Zoom ke Kabupaten Tabalong
                map.fitBounds(tabalongLayer.getBounds());
                originalBounds = tabalongLayer.getBounds();

                // Layer Kecamatan di dalam Tabalong
                var kecamatanLayer = L.geoJSON(data, {
                    filter: function (feature) {
                    return feature.properties &&
                            feature.properties.NAME_2 === "Tabalong" &&
                            feature.properties.NAME_3; // pastikan NAME_3 ada
                    },
                    style: {
                    color: "#000000",
                    weight: 1.5,
                    opacity: 0.7,
                    fillOpacity: 0.1,
                    fillColor: "#ccffcc"
                    },
                    onEachFeature: function (feature, layer) {
                    layer.bindPopup("Kecamatan: " + feature.properties.NAME_3);
                    }
                }).addTo(map);
                })
                .catch(err => console.error("Gagal memuat GeoJSON Tabalong:", err));

            @foreach($pengajuan as $db)
                @foreach($db->lokasi as $lok)
                    @if($lok->latitude && $lok->longitude)
                        var marker = L.marker([{{ $lok->latitude }}, {{ $lok->longitude }}]).addTo(map)
                            .bindPopup(`
                                <div style="font-size: 13px; line-height: 1.4;">
                                    <strong>{{ $lok->nama_lokasi }}</strong>
                                    <table style="margin-top: 6px; border-collapse: collapse;">
                                        <tr>
                                            <td style="vertical-align: top; padding: 2px 8px 2px 0; white-space: nowrap; width: 120px;">Kecamatan</td>
                                            <td style="vertical-align: top;">: {{ $db->kecamatan->nama_kecamatan }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top; padding: 2px 8px 2px 0; white-space: nowrap;">Desa / Kelurahan</td>
                                            <td style="vertical-align: top;">: {{ $db->desakelurahan->nama_desa_kelurahan }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top; padding: 2px 8px 2px 0; white-space: nowrap;">Alamat</td>
                                            <td style="vertical-align: top;">: {{ $db->alamat_aktual }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top; padding: 2px 8px 2px 0; white-space: nowrap;">Status</td>
                                            <td style="vertical-align: top;">: {{ $db->status->last()->nama_status ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            `);
                        markers.push(marker.getLatLng());
                    @endif
                @endforeach
            @endforeach

            // Zoom otomatis jika ada marker
            if (markers.length) {
                var bounds = L.latLngBounds(markers);
                map.fitBounds(bounds, { padding: [30, 30] });
            }
    </script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('pengguna/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('pengguna/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('pengguna/js/main.js') }}"></script>

</body>

</html>