<!doctype html>
<html lang="en">
  <head>
  	<title>Daftar Akun</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
	{!! NoCaptcha::renderJs() !!}

	<style>
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
		.background-blur {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-image: url('{{ asset('pengguna/img/utama.jpg') }}');
			background-size: cover;
			background-position: center;
			filter: blur(8px) brightness(0.6);
			z-index: 0;
		}
		.daftar-container {
			position: relative;
			z-index: 1;
		}
		@media (max-width: 768px) {
			.hide-on-mobile {
				display: none !important;
			}
		}
	</style>
  </head>
  <body>
	
	<!-- BACKGROUND -->
	<div class="background-blur"></div>

	<!-- FORM SECTION -->
	<section class="d-flex align-items-center justify-content-center daftar-container" style="min-height: 100vh;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="row shadow rounded bg-white overflow-hidden">

						<!-- Gambar -->
						<div class="col-md-6 d-flex align-items-center justify-content-center p-4 hide-on-mobile" style="background-color: #f5f5f5;">
							<div style="
								width: 100%;
								max-width: 400px;
								aspect-ratio: 16/10;
								background-image: url('{{ asset('login/images/eGov-Smartcity.jpg') }}');
								background-size: contain;
								background-repeat: no-repeat;
								background-position: center;">
							</div>
						</div>

						<!-- Form Pendaftaran -->
						<div class="col-md-6 p-4">
							<div class="d-flex justify-content-between align-items-center mb-4">
								<h3 class="mb-0">Daftar Akun</h3>
								<a href="{{ route('beranda') }}" class="text-warning d-flex align-items-center text-decoration-none">
									<i class="fa fa-arrow-left me-3"></i> Kembali
								</a>
							</div>

							<form action="{{ route('daftar.submit') }}" method="post" class="signin-form">
								@csrf

								@if(session()->has('success'))
									<div class="alert alert-success">{{ session('success') }}</div>
								@endif
								@if(session()->has('loginError'))
									<div class="alert alert-danger">{{ session('loginError') }}</div>
								@endif

								<div class="form-group mb-3">
									<label for="nama_pengguna" class="label">Nama Lengkap</label>
									<input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('nama_pengguna') }}">
									@error('nama_pengguna')<div class="invalid-feedback">{{ $message }}</div>@enderror
								</div>
								
								<div class="form-group mb-3">
									<label for="no_kontak" class="label">Nomor Kontak</label>
									<input type="text" name="no_kontak" class="form-control @error('no_kontak') is-invalid @enderror" placeholder="Nomor kontak aktif" value="{{ old('no_kontak') }}">
									@error('no_kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
								</div>

								<div class="form-group mb-3">
									<label for="username" class="label">Username</label>
									<input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}">
									@error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
								</div>

								<div class="form-group mb-3">
									<label for="password" class="label">Password</label>
									<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Unik">
									@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
									<small class="form-text text-muted">Gunakan kombinasi huruf besar, angka, dan simbol.</small>
								</div>

								<div class="form-group mb-4 text-center">
									<button type="submit" class="form-control btn btn-primary">Daftar</button>
								</div>
							</form>

							<div class="text-center my-3">
								<hr><span>Atau</span><hr>
							</div>

							<div class="form-group mb-3 text-center">
								<a href="{{ url('auth/google') }}" class="btn btn-danger btn-block" style="background-color: #db4437; color: white;">
									<i class="fa fa-google mr-2"></i> Daftar dengan Google
								</a>
							</div>
						</div> <!-- end form col -->
						
					</div> <!-- end row -->
				</div>
			</div>
		</div>
	</section>

	<script src="{{ asset('login/js/jquery.min.js') }}"></script>
	<script src="{{ asset('login/js/popper.js') }}"></script>
	<script src="{{ asset('login/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('login/js/main.js') }}"></script>
  </body>
</html>