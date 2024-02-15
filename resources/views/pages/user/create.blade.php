@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Add User</h3>
    </div>

    <div class="col-lg-12 container-fluid">
      <a href="/users" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3" method="POST" action="/users">
        @csrf
        <div class="col-lg-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required autofocus>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required autofocus>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
            <label for="role" class="form-label">Role</label>
              <select class="form-select" name="role" id="role">
                <option value="Admin" selected>Admin</option>
                <option value="Cashier" selected>Cashier</option>
              </select>
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
</div>

@endsection