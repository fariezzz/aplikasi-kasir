<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookHaven | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                    <h1 class="h3 mb-5 fw-normal">Registration</h1>
                    <form action="/register" method="POST">
                      @csrf
                      <div class="mb-4">
                        <label for="name" class="mb-2">Name*</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Input your name" value="{{ old('name') }}" autofocus required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="mb-4">
                        <label for="username" class="mb-2">Username*</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Make your username" value="{{ old('username') }}" required>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="mb-4">
                        <label for="email" class="mb-2">Email Address*</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="mb-4">
                        <label for="password">Password*</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Make your password" required>
                      </div>
        
                      <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
                    </form>
                    <small class="d-block text-start mt-2">Already registered? <a href="/login">Login here.</a></small>
                </main>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
  </body>
</html>