<!doctype html>
<html lang="en">
<head>
	<title>Lupa Password</title>
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
							<h3 class="mb-4">Lupa Password</h3>
							<a href="../beranda" class="btn btn-sm btn-outline-secondary">Kembali</a>
						</div>						
						
						@if (session('status'))
							<div class="alert alert-success">{{ session('status') }}</div>
						@endif

						<form method="POST" action="{{ route('password.email') }}" class="signin-form">
							@csrf

							<div class="form-group mb-3">
								<label for="email">Email</label>
								<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email anda..." required>
								@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>

							<div class="form-group mb-3">
								<button type="submit" class="form-control btn btn-primary">Kirim Link Reset</button>
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