<!doctype html>
<html lang="en">
  <head>
    <title>OTP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('khusus/image/komdigi.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      .form-container {
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

    <!-- FORM -->
    <section class="d-flex align-items-center justify-content-center form-container" style="min-height: 100vh;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="row shadow rounded bg-white overflow-hidden">

              <!-- Gambar -->
              <div class="col-md-5 d-flex align-items-center justify-content-center p-4 hide-on-mobile" style="background-color: #f5f5f5;">
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

              <!-- Form -->
              <div class="col-md-7 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  	<h3 class="mb-0">Verifikasi OTP</h3>
                  	<a href="{{ route('beranda') }}" class="text-warning d-flex align-items-center text-decoration-none">
                      <i class="fa fa-arrow-left me-3"></i> Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('otp.verify') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="label">Nomor WhatsApp</label>
                        <input type="text" class="form-control" value="{{ $otps->phone }}" disabled>
                        <input type="hidden" name="phone" value="{{ $otps->phone }}">
                    </div>

                    <div class="form-group mb-3">
                      <label for="otp" class="label">Kode OTP</label>
                        <input type="text" name="otp" class="form-control @error('otp') is-invalid @enderror" placeholder="OTP yang dikirim melalui WhatsApp">
                        @error('otp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                      <button type="submit" class="form-control btn btn-primary">Verifikasi</button>
                    </div>
                </form>
            </div>

            </div> <!-- end row -->
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