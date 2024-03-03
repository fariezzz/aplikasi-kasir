<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Bookhaven | Forgot Password</title>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100" style="width: 50%">
    <div class="border rounded-5 bg-white shadow box-area">      
      <div class="right-box">
        <div class="row align-items-center">
          <div class="header-text mb-3">
            <h2>Insert Your Email</h2>
            @if(session()->has('status'))
                <p class="text-success">{{ session('status') }}</p>
            @endif

            @if($errors->has('emailError'))
              @foreach($errors->get('emailError') as $error)
                <p class="text-danger">{{ $error }}</p>
              @endforeach
            @endif
          </div>
          <form action="/forgot-password" method="POST">
            @csrf
            <div class="input-group mb-3">
              <input type="email" name="email" id="email" class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Your email" autofocus>
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-lg btn-primary w-100 fs-6">Send Request</button>
            </div>
          </form>
        </div>
      </div> 
    </div>
  </div>

  <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  
</body>
</html>
