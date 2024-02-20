<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Bookhaven | Login</title>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #0e2238;">
        <div class="featured-image mb-3">
          <img src="{{ asset('logo/logo-white-no-bg.png') }}" class="img-fluid" style="width: 300px;">
        </div>
      </div> 
        
      <div class="col-md-6 right-box">
        <div class="row align-items-center">
          <div class="header-text mb-4">
            <h2>Sign In</h2>
            <p>Sign in to your account.</p>
          </div>
          <form action="/login" method="POST">
            @csrf
            <div class="input-group mb-3">
              <input type="text" name="username" id="username" class="form-control form-control-lg bg-light fs-6 @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}">
              @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-1">
              <input type="password" name="password" id="password" class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror" placeholder="Password">
              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="bi bi-eye"></i>
              </button>
              @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-5 mt-2 d-flex justify-content-between">
              <div class="form-check">
                  <input type="checkbox" id="remember" name="remember" class="form-check-input" id="formCheck">
                  <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
              </div>
              {{-- <div class="forgot">
                  <small><a href="#">Forgot Password?</a></small>
              </div> --}}
              {{-- <div class="row">
                <small>Don't have account? <a href="#">Sign Up</a></small>
              </div> --}}
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
            </div>
          </form>
        </div>
      </div> 
    </div>
  </div>

  <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('i');
  
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    });
  </script>

</body>
</html>
