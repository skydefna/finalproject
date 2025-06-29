<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'Lain Mata')</title>
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
            <li><a href="{{ route('tamu.beranda') }}" class="active">Beranda<br></a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="{{ route('tamu.pengajuan') }}">Pengajuan</a></li>
            <li><a href="#kontak">Kontak</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>

      <div class="d-flex justify-content-end" style="width: 33%; padding-right: 30px;">
        <div class="dropdown position-relative">
          <a href="#" class="dropdown-toggle-user">
            @auth
              <span>Hai, {{ auth()->user()->nama_pengguna }}</span>
            @endauth
          <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <img src="{{ asset('pengguna/img/utama.jpg') }}" alt="" data-aos="fade-in" class="">
      
      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-out">
          <div class="col-xl-4 col-lg-6 text-center">
            <h1>Lain Mata</h1>
            <p>Layanan Internet Masyarakat Tabalong</p>
          </div>
        </div><br><br>
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4" data-aos="zoom-out" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-book"></i></div>
              <h4 class="title"><a href="#tentang">Panduan</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-md-6 col-lg-4" data-aos="zoom-out" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-geo-alt"></i></div>            
              <h4 class="title"><a href="#peta">Lokasi Pemasangan Lain Mata</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-md-6 col-lg-4" data-aos="zoom-out" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-box"></i></div>
              <h4 class="title"><a href="#rekap">Jumlah Pemasangan Lain Mata</a></h4>
            </div>
          </div>

        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="tentang" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Tentang<br></h2>
        <p>Lain Mata atau Layanan Internet Masyarakat Tabalong adalah program prioritas yang digagas oleh Pemerintah Kabupaten Tabalong yang dikenal dengan "1 Desa 1 WiFi" untuk meningkatkan akses internet bagi masyarakat. Tujuannya adalah untuk mengatasi kesenjangan digital dan memberikan akses internet gratis di seluruh desa.</p>

        <!-- Tombol Unduh Dokumen -->
        <a href="{{ asset('dokumen/PANDUAN LAIN MATA.pdf') }}" download class="btn btn-primary mt-3">
          Unduh Dokumen Panduan
        </a>
      </div><!-- End Section Title -->

    </section><!-- /About Section -->

    
    <section id="rekap" class="stats section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-center fw-bold">Jumlah Pemasangan Lain Mata</h3>
        <div class="row justify-content-center gy-4">
          
          <div class="col-lg-4 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" 
                    data-purecounter-end="{{ $jumlahDisetujui }}" 
                    data-purecounter-duration="1" 
                    class="purecounter display-4 text-primary fw-bold"></span>
              <p class="text-muted">Jumlah Pemasangan Lain Mata</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-4 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" 
                    data-purecounter-end="{{ $rekapPerKecamatan->sum('total_wifi') }}" 
                    data-purecounter-duration="1" 
                    class="purecounter display-4 text-primary fw-bold"></span>
              <p class="text-muted">Jumlah Wifi Per Kecamatan</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-4 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" 
                    data-purecounter-end="{{ $rekapPerDesa->sum('total_wifi') }}" 
                    data-purecounter-duration="1" 
                    class="purecounter display-4 text-primary fw-bold"></span>
              <p class="text-muted">Jumlah Wifi Per Desa / Kelurahan</p>
            </div>
          </div><!-- End Stats Item -->

        </div>
      </div>
    </section>

    <!-- About Alt Section -->
    <section id="peta" class="about-alt section">
      <div class="container">
        <div class="row gy-4">
          <!-- Kolom Map -->
          <div class="col-lg-6 position-relative d-flex justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="100">
            <div style="flex: 3; min-width: 200px; position: relative;">
              <div id="map" style="height: 650px; border: 5px solid #ccc;"></div>
              <div id="resetMapBtn" style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
              </div>
            </div>
          </div>

          <!-- Kolom Tabel Lokasi -->
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
              <h3>Lokasi Data Pengajuan</h3>
              <p class="fst-italic">
                  Berikut adalah tampilan lokasi dari seluruh data pemasangan Lain Mata.
              </p>

              <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama lokasi, kategori, atau alamat...">
              </div>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th style="text-align:center; vertical-align: middle;">No</th>
                                <th style="text-align:center; vertical-align: middle;">Nama Lokasi</th>
                                <th style="text-align:center; vertical-align: middle;">Kategori</th>
                                <th style="text-align:center; vertical-align: middle;">Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                              $no = 1;
                              $index = 0;
                            @endphp

                            @foreach ($pengajuan as $db)
                                @php
                                  $lastStatus = $db->status->last(); // atau ->sortBy('created_at')->last() jika perlu urut manual
                                  $hasDisetujui = strtolower($lastStatus->nama_status ?? '') === 'disetujui';
                                @endphp

                              @if ($hasDisetujui)
                                @foreach ($db->lokasi as $lok)
                                  <tr class="lokasi-row" data-index="{{ $index }}">
                                    <td style="text-align:center; vertical-align: middle;">{{ $no++ }}</td>
                                    <td style="text-align:center; vertical-align: middle;">{{ $lok->nama_lokasi }}</td>
                                    <td style="text-align:center; vertical-align: middle;">{{ $db->kategori->nama_kategori }}</td>
                                    <td>{{ $db->alamat_aktual }}</td>
                                  </tr>
                                  @php $index++; @endphp
                                @endforeach
                              @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
          </div>
      </div>
    </section>

    <script>
      var map = L.map('map').setView([-2.5, 118], 5);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      // Definisikan ikon per kategori
      const icons = {
        'Sekolah': L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          shadowSize: [41, 41]
        }),
        'Fasilitas Umum': L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          shadowSize: [41, 41]
        }),
        'Ruang Terbuka Hijau (RTH)': L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          shadowSize: [41, 41]
        })
      };

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

      @php $index = 0; @endphp
      @foreach($pengajuan as $db)
        @php
          $lastStatus = $db->status->last();
          $hasDisetujui = strtolower($lastStatus->nama_status ?? '') === 'disetujui';          
        @endphp

        @if($hasDisetujui)
          @foreach($db->lokasi as $lok)
            @if(!empty($lok->latitude) && !empty($lok->longitude))
              var marker = L.marker(
                [{{ $lok->latitude }}, {{ $lok->longitude }}],
                { icon: icons["{{ $db->kategori->nama_kategori }}"] || undefined }
              )
              .bindPopup("<strong>{{ $lok->nama_lokasi }}</strong><br>{{ $db->kategori->nama_kategori }}<br>{{ $db->alamat_aktual }}")
              .addTo(map);

              markers.push(marker);
            @endif
            @php $index++; @endphp
          @endforeach
        @endif
      @endforeach

      // Simpan group agar bisa digunakan kembali
      var group = null;
      if (markers.length > 0) {
        group = L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.2));
      }

      // Klik baris = zoom ke marker
      document.querySelectorAll('.lokasi-row').forEach(function(row) {
        row.addEventListener('click', function() {
          var index = this.getAttribute('data-index');
          var marker = markers[index];
          if (marker) {
            map.setView(marker.getLatLng(), 17);
            marker.openPopup();
          }
        });
      });

      // Fitur pencarian tabel
      document.getElementById('searchInput').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.lokasi-row').forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Fitur Reset View Peta
      function resetMapView() {
        if (group) {
          map.fitBounds(group.getBounds().pad(0.2));
        }
      }

      // Tambahkan tombol custom ke peta
      L.Control.ResetView = L.Control.extend({
        onAdd: function(map) {
          var btn = L.DomUtil.create('button', '');
          btn.innerHTML = '🔄 Reset Tampilan';
          btn.style.backgroundColor = 'white';
          btn.style.padding = '5px';
          btn.style.border = '1px solid #888';
          btn.style.cursor = 'pointer';
          btn.style.borderRadius = '5px';
          btn.title = 'Reset Tampilan Peta';

          L.DomEvent.on(btn, 'click', function (e) {
            L.DomEvent.stopPropagation(e);
            resetMapView();
          });

          return btn;
        },
        onRemove: function(map) {}
      });

      L.control.resetView = function(opts) {
        return new L.Control.ResetView(opts);
      }

      L.control.resetView({ position: 'topright' }).addTo(map);
    </script>

    <!-- (Opsional) Tambahkan efek hover agar lebih interaktif -->
    <style>
      .lokasi-row:hover {
        cursor: pointer;
        background-color: #eef7ff;
      }
    </style>

    <!-- Contact Section -->
    <!-- Contact Section -->
    <section id="kontak" class="kontact section" style="background-color: #000; color: #fff; padding: 60px 0; margin-bottom: 30px;">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h3 style="color: #fff; text-align: center;">KONTAK KAMI</h3>
      </div>

      <div class="container">
        <div class="row gy-4 align-items-center h-100" data-aos="fade-up" data-aos-delay="100">
          
          <!-- Kolom Kiri: Peta -->
          <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3831.2316181468514!2d115.37785659678956!3d-2.164074699999993!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfab38183791207%3A0x5fccbd0ea8387377!2sDISKOMINFO%20TABALONG!5e1!3m2!1sid!2sus!4v1749471354111!5m2!1sid!2sus" 
              width="100%" height="450" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>

          <!-- Kolom Kanan: Info Kontak -->
          <div class="col-lg-6 text-start my-auto" data-aos="fade-up" data-aos-delay="300">
            <div class="info-item d-flex align-items-start mb-4">
              <i class="bi bi-geo-alt fs-2 me-3"></i>
              <div>
                <h5 class="mb-1" style="font-size: 1.25rem; color: #fff;">Alamat</h5>
                <p style="font-size: 1.1rem;">Jl. Cempaka, Tanjung, Kabupaten Tabalong, Kalimantan Selatan</p>
              </div>
            </div>

            <div class="info-item d-flex align-items-start mb-4">
              <i class="bi bi-telephone fs-2 me-3"></i>
              <div>
                <h5 class="mb-1" style="font-size: 1.25rem; color: #fff;">Telepon/Fax</h5>
                <p style="font-size: 1.1rem;">(0526) 2023169</p>
              </div>
            </div>

            <div class="info-item d-flex align-items-start">
              <i class="bi bi-envelope fs-2 me-3"></i>
              <div>
                <h5 class="mb-1" style="font-size: 1.25rem; color: #fff;">Email</h5>
                <p style="font-size: 1.1rem;">diskominfo@tabalongkab.go.id</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">
      
    </div>

    <div class="container copyright text-center mt-8">
      <p><span>Copyright ©</span> <strong class="px-1 sitename">2025</strong> <span>Dinas Komunikasi dan Informatika</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

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