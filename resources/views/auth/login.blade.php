<!doctype html>
<html lang="en">
  <head>
  	<title>Lain Mata</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
	{!! NoCaptcha::renderJs() !!}

	<style>
		body, html {
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

		.login-container {
			position: relative;
			z-index: 1;
		}

		.img {
			width: 100%;
			max-width: 300px;
			aspect-ratio: 16/10;
			background-image: url('{{ asset('login/images/eGov-Smartcity.jpg') }}');
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}
	</style>
  </head>
  <body style="background: #f8f9fa;">
  
	<!-- BACKGROUND BLUR -->
	<div class="background-blur"></div>

	<!-- LOGIN CONTENT -->
	<section class="d-flex align-items-center justify-content-center login-container" style="min-height: 100vh;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="row shadow rounded bg-white overflow-hidden">

						<!-- Gambar -->
						<div class="col-md-6 d-flex align-items-center justify-content-center p-4" style="background-color: #f5f5f5;">
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

						<!-- Form Login -->
						<div class="col-md-6 p-4">
							<div class="d-flex justify-content-between align-items-center mb-4">
								<h3 class="m-0">Masuk</h3>
								<a href="{{ route('beranda') }}" class="text-warning d-flex align-items-center text-decoration-none">
									<i class="fa fa-arrow-left me-3"></i> Kembali
								</a>
							</div>

							<form action="{{ route('login.submit') }}" method="post" class="signin-form">
								@csrf

								@if(session()->has('success'))
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										{{ session('success') }}
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								@endif

								@if(session()->has('loginError'))
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										{{ session('loginError') }}
									</div>
								@endif

								<div class="form-group mb-3">
									<label class="label">Username atau Email</label>
									<input type="text" name="login" class="form-control @error('login') is-invalid @enderror" placeholder="login" autofocus value="{{ old('login') }}">
									@error('login')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>

								<div class="form-group mb-3">
									<label class="label">Password</label>
									<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
									@error('password')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>

								<p class="text-center mt-3">
									<a href="{{ route('password.request', ['login' => old('login')]) }}">
										Lupa Password?
									</a>
								</p>

								<div class="form-group mb-3 text-center">
									<div class="d-inline-block">
										{!! NoCaptcha::display() !!}
									</div>
									@error('g-recaptcha-response')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>

								<div class="form-group mb-3 text-center">
									<button type="submit" class="btn btn-warning text-white" style="width: 250px;">Masuk</button>
								</div>

								<div class="form-group mb-3 text-center">
									<p class="text-center mt-3">
										Belum punya akun? <a href="{{ url('auth/google') }}" style="color: orange;">Daftar Disini</a>
									</p>
								</div>
							</form>
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