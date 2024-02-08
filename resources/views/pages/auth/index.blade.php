@extends('layouts.auth')

@section('container')

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
    <input type="username" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username') }}" autofocus required>
    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="mb-4">
    <label for="password" class="mb-2">Password*</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
  </div>

  <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
</form>
<small class="d-block text-start mt-2">Not registered? <a href="/register">Register here.</a></small>
@endsection