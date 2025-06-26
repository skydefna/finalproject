<!doctype html>
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lain Mata</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('khusus/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('khusus/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('khusus/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('khusus/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('khusus/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('khusus/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('khusus/scss/style.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

</head>
<body>

    <script src="{{ asset('khusus/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('khusus/js/popper.min.js') }}"></script>
    <script src="{{ asset('khusus/js/plugins.js') }}"></script>
    <script src="{{ asset('khusus/js/main.js') }}"></script>

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('teknisi.beranda') }}">Lain Mata</a>
                <a class="navbar-brand hidden" href="{{ route('teknisi.beranda') }}"></a>
            </div>

             <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" class="toggle-submenu" style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="display: flex; align-items: center;">
                                <i class="menu-icon fa fa-pencil-square-o" style="margin-right: 8px;"></i>
                                <span>Data Keseluruhan</span>
                            </span>
                            <i class="fa fa-caret-down dropdown-icon"></i>
                        </a>

                        <ul class="submenu" style="display: none; padding-left: 40px;">
                            <li>
                                <a href="{{ route('teknisi.keseluruhan.tabel') }}" style="display: flex; align-items: center;">
                                    <i class="fa fa-table" style="margin-right: 21px;"></i> Data Tabel
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('teknisi.keseluruhan.visual') }}" style="display: flex; align-items: center;">
                                    <i class="fa fa-bar-chart" style="margin-right: 20px;"></i> Data Visual
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('teknisi.pengajuan') }}" style="display: flex; align-items: center;">
                            <i class="menu-icon fa fa-pencil-square-o" style="margin-right: 8px;"></i> Data Pengajuan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teknisi.survei') }}" style="display: flex; align-items: center;">
                            <i class="menu-icon fa fa-pencil-square-o" style="margin-right: 8px;"></i> Data Survei
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('aduan.teknisi') }}" style="display: flex; align-items: center;">
                            <i class="menu-icon fa fa-pencil-square-o" style="margin-right: 8px;"></i> Data Lapor Aduan
                        </a>
                    </li>
                                        <li>
                        <a href="{{ route('teknisi.data') }}" style="display: flex; align-items: center;">
                            <i class="menu-icon fa fa-pencil-square-o" style="margin-right: 8px;"></i> Data Pemasangan
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.toggle-submenu').forEach(function (el) {
                        el.addEventListener('click', function (e) {
                            e.preventDefault();
                            const submenu = this.nextElementSibling;
                            const icon = this.querySelector('.dropdown-icon');

                            if (submenu.style.display === 'none' || submenu.style.display === '') {
                                submenu.style.display = 'block';
                                if (icon) icon.className = 'fa fa-caret-up dropdown-icon';
                            } else {
                                submenu.style.display = 'none';
                                if (icon) icon.className = 'fa fa-caret-down dropdown-icon';
                            }
                        });
                    });
                });
            </script>
        </nav>
    </aside><!-- /#left-panel -->

    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                </div>

                <div class="col-sm-5 d-flex justify-content-end align-items-center">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hai, {{ auth()->user()->nama_pengguna }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        @yield('breadcrumbs')

        @yield('content')
    </div>

</body>
</html>