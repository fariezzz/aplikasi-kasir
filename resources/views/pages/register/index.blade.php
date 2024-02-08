@extends('layouts.auth')

@section('container')
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
  <div class="mb-4">
    <select name="role" id="role">
      <option value="Admin">Admin</option>
      <option value="Cashier">Cashier</option>
    </select>
  </div>
  <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
</form>
<small class="d-block text-start mt-2">Already registered? <a href="/login">Login here.</a></small>
@endsection