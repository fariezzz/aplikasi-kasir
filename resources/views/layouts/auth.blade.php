<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookHaven | {{ $title }}</title>
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        body {
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          margin: 0;
          font-family: 'Poppins', sans-serif;
        }

        .border-container {
            border: 2px solid #000000;
            padding: 60px;
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
        }
      </style>

  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center align-items-center m-auto">
          <div class="col-lg-4">        
              <main class="form-signin w-100 m-auto">
                @if(session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show col" role="alert">
                  {{ session('failed') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              
              <h1 class="h3 mb-5 fw-normal">Login</h1>
              <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                  <label for="username" class="mb-2">Username*</label>
                  <input type="username" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username') }}" style="border-radius: 8px;
                  border-color:rgb(100, 100, 100);" autofocus required>
                  @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                  <label for="password" class="mb-2">Password*</label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" style="border-radius: 8px 0px 0px 8px;
                    border-color:rgb(100, 100, 100);" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>
              
                <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
              </form>
              <small class="d-block text-start mt-2">Not registered? <a href="/register">Register here.</a></small>
              </main>
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