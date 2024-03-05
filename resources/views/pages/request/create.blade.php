<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}" />
    <title>Bookhaven | Making a Request</title>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100" id="request">
    <div class="border rounded-5 bg-white shadow box-area">
      <div class="right-box">
        @include('partials.alert')
        <div class="row align-items-center">
          <div class="header-text mb-3">
            <h2>Request Form</h2>
            <p>This form will be sent to the admin for processing. You will receive the information via Gmail later.</p>
          </div>
          <form action="/account-requests" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" name="name" id="name" class="form-control form-control-lg bg-light fs-6 @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}" autofocus required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
                <input type="email" name="email" id="email" class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
                <input type="text" name="username" id="username" class="form-control form-control-lg bg-light fs-6 @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
                <select type="text" name="role" id="role" class="form-select form-select-lg bg-light fs-6 @error('role') is-invalid @enderror" placeholder="Role you want">
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Cashier" {{ old('role') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-3">
                <textarea name="reasons" id="reasons" class="form-control form-control-lg bg-light fs-6 @error('reasons') is-invalid @enderror" placeholder="Your reason">{{ old('reasons') }}</textarea>
                @error('reasons')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="input-group mb-1">
              <button type="submit" id="submitButton" class="btn btn-lg btn-primary w-100 fs-6">Send</button>
            </div>
            <small><a href="/login">Back to Login Page.</a></small>
          </form>
        </div>
      </div> 
    </div>
  </div>

  <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      form.addEventListener('submit', function() {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
      });
    });
  </script>
</body>
</html>