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
					<div class="col-md-6 p-4">
						<div class="d-flex justify-content-between align-items-center">
							<h3 class="mb-4">Lupa Kata Sandi</h3>
							<a href="{{ route('beranda') }}" class="text-warning d-flex align-items-center text-decoration-none">
								<i class="fa fa-arrow-left me-3"></i> Kembali
							</a>
						</div>						
						
						@if (session('status'))
							<div class="alert alert-success">{{ session('status') }}</div>
						@endif

						<form method="POST" action="{{ route('password.email') }}">
							@csrf
							<div class="form-group">
								<label>Email Anda</label>
								<input type="email" name="email" class="form-control" value="{{ old('email', request('login')) }}" readonly>
								@error('email') <div class="text-danger">{{ $message }}</div> @enderror
							</div>
							<button type="submit" class="btn btn-warning mt-2">Kirim Link Reset</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('email-input');

        // Isi otomatis dari localStorage jika ada
        const savedEmail = localStorage.getItem('lastUsedEmail');
        if (savedEmail) {
            emailInput.value = savedEmail;
        }

        // Simpan ke localStorage saat form dikirim
        const form = emailInput.closest('form');
        form.addEventListener('submit', function () {
            localStorage.setItem('lastUsedEmail', emailInput.value);
        });
    });
</script>

<script src="{{ asset('login/js/jquery.min.js') }}"></script>
<script src="{{ asset('login/js/popper.js') }}"></script>
<script src="{{ asset('login/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('login/js/main.js') }}"></script>
</body>
</html>