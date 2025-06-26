@extends('content.05.menu_akun')

@section('title', 'Lain Mata')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="row">
        <!-- Kolom Kiri (judul) -->
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Data Tabel</h1>
                </div>
            </div>
        </div>

        <!-- Kolom Tengah (navigasi internal section) -->
        <div class="col-sm-4 d-flex justify-content-center align-items-center">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#koneksi">Koneksi</a></li>
                <li class="breadcrumb-item"><a href="#status">Status</a></li>
                <li class="breadcrumb-item"><a href="#kecamatan">Kecamatan</a></li>
                <li class="breadcrumb-item"><a href="#desa">Desa</a></li>
            </ol>
        </div>

        <!-- Kolom Kanan (link ke beranda) -->
        <div class="col-sm-4">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('akun.keseluruhan.tabel') }}">Beranda</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="content mt-3">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="card text-white bg-primary rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Usulan:</p>
                            <h4 class="mb-0">{{ $jumlahPengajuan }}</h4>
                        </div>
                        <i class="fa fa-user fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Diajukan</p>
                            <h4>{{ $jumlahDiajukan }}</h4>
                        </div>
                        <i class="fa fa-hourglass-half fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Disetujui</p>
                            <h4>{{ $jumlahDisetujui }}</h4>
                        </div>
                        <i class="fa fa-check-circle fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger rounded">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-white">Jumlah Ditolak</p>
                            <h4>{{ $jumlahDitolak }}</h4>
                        </div>
                        <i class="fa fa-times-circle fa-2x" style="opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipe Koneksi -->
        <section id="koneksi" class="koneksi section">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <strong>Rekap Jumlah Tipe Koneksi </strong>
                        </div>                    
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="text-align:center; vertical-align: middle;">No</th>
                                        <th style="text-align:center; vertical-align: middle;">Tipe Koneksi / Provider</th>
                                        <th style="text-align:center; vertical-align: middle;">Jumlah Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rekapTipeKoneksi as $index => $item)
                                        <tr>
                                            <td style="text-align:center; vertical-align: middle;">{{ $index + 1 }}</td>
                                            <td>{{ $item->tipe_koneksi ?? 'Tidak Diisi' }}</td>
                                            <td style="text-align:center; vertical-align: middle;">{{ $item->total }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="2" style="text-align:center; vertical-align: middle;">Total</th>
                                        <th style="text-align:center; vertical-align: middle;">
                                            {{ $rekapTipeKoneksi->sum('total') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Status Aktif per Desa -->
        <section id="status" class="status section">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <strong>Rekap Status Aktif/Mati per Desa/Kelurahan</strong>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="text-align:center; vertical-align: middle;">No</th>
                                        <th style="text-align:center; vertical-align: middle;">Nama Desa/Kelurahan</th>
                                        <th style="text-align:center; vertical-align: middle;">Status</th>
                                        <th style="text-align:center; vertical-align: middle;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekapStatusAktifPerDesa as $index => $item)
                                    <tr>
                                        <td style="text-align:center; vertical-align: middle;">{{ $index + 1 }}</td>
                                        <td>{{ $item->nama_desa_kelurahan }}</td>
                                        <td style="text-align:center; vertical-align: middle;">
                                            @if($item->status === 'Aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Mati</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center; vertical-align: middle;">{{ $item->total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" style="text-align:center; vertical-align: middle;">Total Aktif</td>
                                        <td style="text-align:center; vertical-align: middle;">
                                            {{ $rekapStatusAktifPerDesa->where('status', 'Aktif')->sum('total') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:center; vertical-align: middle;">Total Mati</td>
                                        <td style="text-align:center; vertical-align: middle;">
                                            {{ $rekapStatusAktifPerDesa->where('status', 'Mati')->sum('total') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WiFi per Kecamatan Chart -->
        <section id="kecamatan" class="kecamatan section">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <strong>Rekap Jumlah WiFi per Kecamatan</strong>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="text-align:center; vertical-align: middle;">No</th>
                                        <th style="text-align:center; vertical-align: middle;">Nama Kecamatan</th>
                                        <th style="text-align:center; vertical-align: middle;">Jumlah WiFi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekapPerKecamatan as $index => $kecamatan)
                                    <tr>
                                        <td style="text-align:center; vertical-align: middle;">{{ $index + 1 }}</td>
                                        <td>{{ $kecamatan->nama_kecamatan }}</td>
                                        <td style="text-align:center; vertical-align: middle;">{{ $kecamatan->total_wifi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="2" style="text-align:center; vertical-align: middle;">Total</th>
                                        <th style="text-align:center; vertical-align: middle;">
                                            {{ $rekapPerKecamatan->sum('total_wifi') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="desa" class="desa section">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <strong>Rekap Jumlah WiFi per Desa/Kelurahan</strong>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="text-align:center; vertical-align: middle;">No</th>
                                        <th style="text-align:center; vertical-align: middle;">Nama Desa/Kelurahan</th>
                                        <th style="text-align:center; vertical-align: middle;">Jumlah WiFi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekapPerDesa as $index => $desa)
                                    <tr>
                                        <td style="text-align:center; vertical-align: middle;">{{ $index + 1 }}</td>
                                        <td>{{ $desa->nama_desa_kelurahan }}</td>
                                        <td style="text-align:center; vertical-align: middle;">{{ $desa->total_wifi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="2" style="text-align:center; vertical-align: middle;">Total</th>
                                        <th style="text-align:center; vertical-align: middle;">
                                            {{ $rekapPerDesa->sum('total_wifi') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<a href="#" id="scroll-top"
   class="scroll-top d-flex justify-content-center align-items-center"
   style="position: fixed; bottom: 30px; right: 30px; width: 40px; height: 40px; background: #0d6efd; color: white; border-radius: 50%; font-size: 24px; z-index: 999; display: none;">
   <i class="fa fa-arrow-up"></i>
</a>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollBtn = document.getElementById("scroll-top");

        // Ganti ini sesuai dengan kontainer scroll-mu (main, .content-wrapper, dsb)
        const scrollContainer = document.querySelector('main'); // Ubah jika kontainermu pakai class lain

        // Fungsi untuk menunjukkan atau menyembunyikan tombol scroll-up
        function toggleScrollButton() {
            if (scrollContainer.scrollTop > 100) {
                scrollBtn.style.display = "flex";
            } else {
                scrollBtn.style.display = "none";
            }
        }

        // Dengarkan scroll dari kontainer, bukan dari window
        scrollContainer.addEventListener("scroll", toggleScrollButton);

        // Jalankan fungsi saat DOM selesai dimuat
        toggleScrollButton();

        // Klik untuk scroll ke atas
        scrollBtn.addEventListener("click", function (e) {
            e.preventDefault();
            scrollContainer.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    });
</script>
@endsection