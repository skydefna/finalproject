<!doctype html>
<html lang="en">
  <head>
  	<title>Lain Mata</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
							<h3 class="mb-4">Reset Password</h3>
							<a href="{{ route('beranda') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
						</div>						

						<form method="POST" action="{{ route('password.update') }}">
							@csrf

							<input type="hidden" name="token" value="{{ $token }}">
							<input type="hidden" name="email" value="{{ $email }}">

							<div class="form-group mb-3">
								<label for="password" class="label">Password</label>
								<div class="input-group">
									<input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata sandi anda...">
									<div class="input-group-append">
										<button type="button" class="input-group-text" onclick="togglePassword()" style="cursor: pointer;" aria-label="Tampilkan password">
											<i id="toggleIcon" class="fas fa-eye"></i>
										</button>
									</div>
								</div>
								@error('password')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<small class="form-text text-muted">Gunakan kombinasi huruf besar, angka, dan simbol. Misal: Abcd@123</small>
							</div>

							<button type="submit" class="btn btn-success mt-2">Ubah Password</button>
						</form>
					</div> 
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	function togglePassword() {
		const passwordInput = document.getElementById("password");
		const toggleIcon = document.getElementById("toggleIcon");

		if (passwordInput.type === "password") {
			passwordInput.type = "text";
			toggleIcon.classList.remove("fa-eye");
			toggleIcon.classList.add("fa-eye-slash");
		} else {
			passwordInput.type = "password";
			toggleIcon.classList.remove("fa-eye-slash");
			toggleIcon.classList.add("fa-eye");
		}
	}
</script>

<script src="{{ asset('login/js/jquery.min.js') }}"></script>
<script src="{{ asset('login/js/popper.js') }}"></script>
<script src="{{ asset('login/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('login/js/main.js') }}"></script>
</body>
</html>