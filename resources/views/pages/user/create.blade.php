@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Add User</h3>
    </div>

    <div class="col-lg-12 container-fluid">
      <a href="/users" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3 myForm" method="POST" action="/users">
        @csrf
        <input type="hidden" name="request_id" id="request_id" value="{{ request('request_id') }}">
        <div class="col-lg-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', request('name')) }}" required autofocus>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', request('email')) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', request('username')) }}" required>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="role" class="form-label">Role</label>
            <select class="form-select" name="role" id="role">
              <option value="Admin" {{ old('role', request('role')) === 'Admin' ? 'selected' : ''}}>Admin</option>
              <option value="Cashier" {{ old('role', request('role')) === 'Cashier' ? 'selected' : ''}}>Cashier</option>
            </select>
        </div>

        <div class="col-lg-6">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control password-input @error('password') is-invalid @enderror" id="password" name="password" required>
            <button class="btn btn-outline-secondary togglePassword" type="button" style="border-left: 0"><i class="bi bi-eye"></i></button>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-lg-6">
          <label for="password" class="form-label">Confirm Password</label>
          <div class="input-group">
            <input type="password" class="form-control password-input @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" required>
            <button class="btn btn-outline-secondary togglePassword" type="button" style="border-left: 0"><i class="bi bi-eye"></i></button>
            @error('confirm_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>   

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary submitButton">Add</button>
        </div>

      </form>

    </div>
</div>

<script>
  $(document).ready(function () {
    $('.togglePassword').click(function() {
      const passwordInput = $(this).siblings('input');
      const icon = $(this).find('i');

      if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        icon.removeClass('bi-eye').addClass('bi-eye-slash');
      } else {
        passwordInput.attr('type', 'password');
        icon.removeClass('bi-eye-slash').addClass('bi-eye');
      }
    });
  });
</script>

@endsection