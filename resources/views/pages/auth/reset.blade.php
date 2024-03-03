<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Bookhaven | Reset Password</title>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100" style="width: 50%">
    <div class="border rounded-5 bg-white shadow box-area">      
      <div class="right-box">
        <div class="row align-items-center">
          @if($errors->has('emailError'))
              @foreach($errors->get('emailError') as $error)
                <p class="text-danger">{{ $error }}</p>
              @endforeach
            @endif
          <div class="header-text mb-3">
            <h2>Reset Password</h2>
          </div>
          <form action="/reset-password" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="input-group mb-3">
                <input type="password" name="password" id="password" class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror" placeholder="Password">
                <button class="btn btn-outline-secondary togglePassword" type="button" data-target="password" style="border-left: 0px">
                  <i class="bi bi-eye"></i>
                </button>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg bg-light fs-6 @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation">
                <button class="btn btn-outline-secondary togglePassword" type="button" data-target="password_confirmation" style="border-left: 0px">
                  <i class="bi bi-eye"></i>
                </button>
                @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-lg btn-primary w-100 fs-6">Reset Password</button>
            </div>
          </form>
        </div>
      </div> 
    </div>
  </div>

  <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.querySelectorAll('.togglePassword').forEach(function(button) {
      button.addEventListener('click', function() {
        var targetId = this.getAttribute('data-target');
        var targetInput = document.getElementById(targetId);
        if (targetInput.type === 'password') {
          targetInput.type = 'text';
          this.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
          targetInput.type = 'password';
          this.innerHTML = '<i class="bi bi-eye"></i>';
        }
      });
    });
  </script>
</body>
</html>
