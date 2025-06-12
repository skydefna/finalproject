<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Lain Mata</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">
  <link href="{{ asset('pengguna/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('pengguna/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pengguna/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('pengguna/css/main.css') }}" rel="stylesheet">

  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <div class="d-flex align-items-center" style="width: 33%; padding-left: 30px;" >
        <a href="{{ route('admin.beranda') }}">
          <h1 class="sitename">Lain Mata</h1>
        </a>
      </div>
      
      <div class="d-flex justify-content-center" style="width: 34%;" >
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('admin.beranda') }}" class="active">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li class="dropdown"><a href="#"><span>Data Admin</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li class="dropdown">
                  <a href="#"><span>Data Keseluruhan</span> <i class="bi bi-chevron-right toggle-dropdown"></i></a>
                  <ul class="dropdown-menu dropdown-submenu" style="left: 100%; top: 0;">
                    <li><a href="{{ route('admin.keseluruhan.tabel') }}">Data Tabel</a></li>
                    <li><a href="{{ route('admin.keseluruhan.visual') }}">Data Visual</a></li>
                  </ul>
                </li>
                <li><a href="{{ route('admin.pengajuan')}}">Data Pengajuan</a></li>
                <li><a href="{{ route('admin.teknisi')}}">Data Lapangan</a></li>
              </ul>
            </li>
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
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Keluar</button>
              </form>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </header>

  <main class="main">

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
              <h4 class="title"><a href="#tentang">Tentang</a></h4>
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
                <button class="btn btn-sm btn-secondary">Reset Peta</button>
              </div>
            </div>
          </div>

          <!-- Kolom Tabel Lokasi -->
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Lokasi Data Pengajuan</h3>
            <p class="fst-italic">Berikut adalah tampilan lokasi dari seluruh data pemasangan Lain Mata.</p>

            <div class="d-flex justify-content-between mb-3">
              <div>
                <label for="statusFilter">Filter Status:</label>
                <select id="statusFilter" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                  <option value="">Semua</option>
                  <option value="diajukan">Diajukan</option>
                  <option value="disetujui">Disetujui</option>
                  <option value="ditolak">Ditolak</option>
                </select>
              </div>
              <div>
                <input type="text" id="searchBox" placeholder="Cari..." class="form-control form-control-sm" style="width: 200px;">
              </div>
            </div>

            <div id="tableContainer" class="table-responsive" style="max-height: 500px; overflow-y: auto;">
              <table id="tabelLokasi" class="table-striped table-bordered table" style="width: 100%;">
                <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                  <tr>
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Nama Lokasi</th>
                    <th style="text-align:center;">Kategori</th>
                    <th style="text-align:center;">Alamat</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Status Aktif</th> 
                  </tr>
                </thead>
                <tbody>
                  @php $no = 1; $index = 0; @endphp
                  @foreach ($pengajuan as $db)
                    @php
                      $latestStatus = $db->status->last();
                      $statusText = strtolower(optional($latestStatus)->nama_status ?? 'diajukan');
                      $statusColors = ['diajukan' => 'text-primary', 'disetujui' => 'text-success', 'ditolak' => 'text-danger'];
                    @endphp
                    @foreach ($db->lokasi as $lok)
                      <tr class="lokasi-row" data-index="{{ $index++ }}" data-status="{{ $statusText }}">
                        <td style="text-align:center; vertical-align: middle;">{{ $no++ }}</td>
                        <td class="nama-lokasi" style="text-align:center; vertical-align: middle;">{{ $lok->nama_lokasi }}</td>
                        <td class="kategori" style="text-align:center; vertical-align: middle;">{{ $db->kategori->nama_kategori }}</td>
                        <td class="alamat" style="vertical-align: middle;">{{ $db->alamat_aktual }}</td>
                        <td class="{{ $statusColors[$statusText] ?? 'text-secondary' }}" style="text-align:center; vertical-align: middle;">
                          {{ ucfirst($statusText) }}
                        </td>
                        <td style="text-align:center; vertical-align: middle;">
                          @if($db->status_on)
                            <span class="text-success">Aktif</span>
                          @else
                            <span class="text-danger">Tidak Aktif</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      let originalBounds = null;
      let lastSelectedRow = null;
      let isZoomedIn = false;
      let lastSelectedMarker = null;
      let markerData = [];

      document.addEventListener("DOMContentLoaded", function () {
        setTimeout(filterTableAndMap, 1000)
      });

      document.getElementById('statusFilter').addEventListener('change', filterTableAndMap);
      document.getElementById('searchBox').addEventListener('input', filterTableAndMap);

      var map = L.map('map').setView([-2.5, 118], 5);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      setTimeout(() => {
        map.invalidateSize();
      }, 500);

      // Tambahkan batas wilayah Kabupaten Tabalong dari GeoJSON
      fetch("/geojson/Tabalong.json")
        .then(response => response.json())
        .then(data => {
          var tabalongLayer = L.geoJSON(data, {
            filter: function (feature) {
              return feature.properties && feature.properties.NAME_2 === "Tabalong";
            },
            style: function (feature) {
              return {
                color: "#000000",
                weight: 2,
                opacity: 0.8,
                fillOpacity: 0.05,
                fillColor: "#66b2ff"
              };
            },
            onEachFeature: function (feature, layer) {
              if (feature.properties && feature.properties.NAME_2) {
                layer.bindPopup("Wilayah: " + feature.properties.NAME_2);
              }
            }
          }).addTo(map);
          
          map.fitBounds(tabalongLayer.getBounds());
          originalBounds = tabalongLayer.getBounds();
        })
        .catch(err => console.error("Gagal memuat GeoJSON Tabalong:", err));

      @php
        $iconColors = ['diajukan' => 'blue', 'disetujui' => 'green', 'ditolak' => 'red'];
      @endphp

      @foreach($pengajuan as $db)
        @php
          $lastStatus = strtolower(optional($db->status->last())->nama_status ?? 'diajukan');
          $iconColor = $iconColors[$lastStatus] ?? 'gray';
        @endphp
        @foreach($db->lokasi as $lok)
          @if(!empty($lok->latitude) && !empty($lok->longitude))
            @php $isActive = $db->status_on; @endphp
            var customIcon = L.divIcon({
              className: '',
              html: `{!! '<div style="position:relative;">
                        <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-'. $iconColor .'.png" style="display:block;margin:0 auto;">
                        <i class="bi '. ($db->status_on ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger') .'" style="position:absolute;top:-8px;right:-12px;font-size:18px;"></i>
                      </div>' !!}`,
              iconSize: [25, 55],
              iconAnchor: [12, 55],
            });

            var marker = L.marker([{{ $lok->latitude }}, {{ $lok->longitude }}], { icon: customIcon })
              .bindPopup("<strong>{{ $lok->nama_lokasi }}</strong><br>{{ $db->kategori->nama_kategori }}<br>{{ $db->alamat_aktual }}<br>Status: {{ ucfirst($lastStatus) }}")
              .addTo(map);

            markerData.push({
              marker: marker,
              status: "{{ $lastStatus }}",
              nama: "{{ strtolower($lok->nama_lokasi) }}"
            });
          @endif
        @endforeach
      @endforeach

      if (markerData.length > 0 && !originalBounds) {
        var group = L.featureGroup(markerData.map(m => m.marker));
        originalBounds = group.getBounds();
        map.fitBounds(originalBounds.pad(0.2));
      }

      document.getElementById("resetMapBtn").addEventListener("click", function () {
        if (originalBounds) {
          map.fitBounds(originalBounds.pad(0.2));
          if (lastSelectedMarker) lastSelectedMarker.setZIndexOffset(0);
          if (lastSelectedRow) lastSelectedRow.classList.remove("selected-row");
          lastSelectedMarker = null;
          lastSelectedRow = null;
          isZoomedIn = false;
        }
      });

      function refreshRowListeners() {
        document.querySelectorAll('.lokasi-row').forEach((row, visualIndex) => {
          row.addEventListener('click', function () {
            const logicalIndex = parseInt(this.getAttribute('data-index'));
            const marker = markerData[logicalIndex]?.marker;
            if (!marker) return;

            if (lastSelectedRow === this && isZoomedIn) {
              map.fitBounds(originalBounds.pad(0.2));
              this.classList.remove('selected-row');
              if (lastSelectedMarker) lastSelectedMarker.setZIndexOffset(0);
              lastSelectedMarker = null;
              lastSelectedRow = null;
              isZoomedIn = false;
              return;
            }

            map.setView(marker.getLatLng(), 17);
            marker.openPopup();
            document.querySelectorAll('.lokasi-row').forEach(r => r.classList.remove('selected-row'));
            this.classList.add('selected-row');
            if (lastSelectedMarker) lastSelectedMarker.setZIndexOffset(0);
            marker.setZIndexOffset(1000);

            lastSelectedMarker = marker;
            lastSelectedRow = this;
            isZoomedIn = true;
          });
        });
      }

      function filterTableAndMap() {
        const status = document.getElementById('statusFilter').value.toLowerCase();
        const keyword = document.getElementById('searchBox').value.toLowerCase();
        const rows = Array.from(document.querySelectorAll('.lokasi-row'));
        let bounds = [];

        rows.forEach((row, i) => {
          const rowStatus = row.getAttribute('data-status');
          const nama = row.querySelector('.nama-lokasi')?.textContent.toLowerCase() || '';
          const kategori = row.querySelector('.kategori')?.textContent.toLowerCase() || '';
          const alamat = row.querySelector('.alamat')?.textContent.toLowerCase() || '';
          const cocok = (!status || rowStatus === status) && (!keyword || nama.includes(keyword) || kategori.includes(keyword) || alamat.includes(keyword));
          const marker = markerData[i]?.marker;

          if (cocok) {
            row.style.display = '';
            if (marker) {
              map.addLayer(marker);
              bounds.push(marker.getLatLng());
            }
          } else {
            row.style.display = 'none';
            if (marker) {
              map.removeLayer(marker);
            }
          }
        });

        if (bounds.length > 0) {
          map.fitBounds(L.latLngBounds(bounds), { padding: [20, 20] });
          originalBounds = L.latLngBounds(bounds);
        }

        refreshRowListeners();
      }
    </script>

    <style>
    .lokasi-row:hover {
      cursor: pointer;
      background-color: #eef7ff;
    }
    .selected-row {
      background-color: #d3e5ff !important;
    }
    #tableContainer {
      max-height: 400px;
      overflow-y: auto;
    }
    </style>

    <!-- Contact Section -->
    <!-- Contact Section -->
    <section id="kontak" class="kontact section" style="background-color: #000; color: #fff; padding: 60px 0;">
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
  <!-- Include Bootstrap JS -->


</body>

</html>