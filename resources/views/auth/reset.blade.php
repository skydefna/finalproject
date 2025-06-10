<!doctype html>
<html lang="en">
<head>
	<title>Reset Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
</head>
<body>
<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-10">
				<div class="wrap d-md-flex">
					<div class="img" style="background-image: url('{{ asset('login/images/TabalongSmartCity.jpg') }}');"></div>
					<div class="login-wrap p-4 p-md-5">
						<div class="d-flex justify-content-between align-items-center">
							<h3 class="mb-4">Reset Password</h3>
							<a href="../beranda" class="btn btn-sm btn-outline-secondary">Kembali</a>
						</div>						

						<form method="POST" action="{{ route('password.update') }}" class="signin-form">
							@csrf

							{{-- Token --}}
							<input type="hidden" name="token" value="{{ $token }}">

							{{-- Email --}}
							<div class="form-group mb-3">
								<label for="email">Email</label>
								<input type="email" name="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email anda..." required autofocus>
								@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>

							{{-- Password Baru --}}
							<div class="form-group mb-3">
								<label for="password">Password Baru</label>
								<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password baru..." required>
								@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>

							{{-- Konfirmasi Password --}}
							<div class="form-group mb-3">
								<label for="password_confirmation">Konfirmasi Password</label>
								<input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password..." required>
							</div>

							{{-- Submit --}}
							<div class="form-group mb-3">
								<button type="submit" class="form-control btn btn-primary">Reset Password</button>
							</div>
						</form>
					</div> 
				</div>
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