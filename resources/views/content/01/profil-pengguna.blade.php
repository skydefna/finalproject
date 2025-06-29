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
                <li><a href="{{ route('tamu.pengajuan') }}">Pengajuan</a></li>
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
            <section class="section profile pt-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-white">Data Pribadi Pengguna</h5>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                                        <i class="bi bi-pencil-fill me-1"></i> Edit Profil
                                    </button>
                                </div>
                                <div class="card-body">

                                    <div class="row mb-3">
                                        <div class="col-sm-4 fw-semibold">Nama</div>
                                        <div class="col-sm-8">{{ auth()->user()->nama_pengguna ?? '-' }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4 fw-semibold">Email</div>
                                        <div class="col-sm-8">{{ auth()->user()->email ?? '-' }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4 fw-semibold">Nomor Kontak</div>
                                        <div class="col-sm-8">{{ auth()->user()->no_kontak ?? '-' }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4 fw-semibold">NIK</div>
                                        <div class="col-sm-8">{{ auth()->user()->nik ?? '-' }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4 fw-semibold">Nama Instansi</div>
                                        <div class="col-sm-8">{{ auth()->user()->nama_instansi ?? '-' }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4 fw-semibold">Jabatan</div>
                                        <div class="col-sm-8">{{ auth()->user()->jabatan ?? '-' }}</div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
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

        {{-- ===== MODAL EDIT PROFIL ===== --}}
        <div class="modal fade" id="modalEditProfil" tabindex="-1" aria-labelledby="modalEditProfilLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <form action="{{ route('tamu.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditProfilLabel">Edit Data Pribadi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Kontak</label>
                            <input type="text" name="no_kontak" class="form-control" value="{{ old('no_kontak', auth()->user()->no_kontak) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik', auth()->user()->nik) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Instansi</label>
                            <input type="text" name="nama_instansi" class="form-control" value="{{ old('nama_instansi', auth()->user()->nama_instansi) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', auth()->user()->jabatan) }}">
                        </div>
                    </div>

                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        {{-- ===== END MODAL ===== --}}

    </main>

    <footer id="footer" class="footer light-background">

        <div class="container copyright text-center mt-8">
        <p><span>Copyright ©</span> <strong class="px-1 sitename">2025</strong> <span>Dinas Komunikasi dan Informatika</span></p>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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