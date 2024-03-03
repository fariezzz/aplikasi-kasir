@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
    <h3>{{ auth()->user()->name}}'s Profile</h3>
  </div>

  @include('partials.alert')

  @include('partials.alertError')

  @error('currentPassword')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  @error('newPassword')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  @error('confirmPassword')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  @error('image')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror
  
  <div class="col-lg-12 container-fluid">
    <form id="profileForm" class="row g-3" method="POST" action="/update-user/{{ auth()->user()->username }}" enctype="multipart/form-data">
      @csrf
      <div class="profile-picture d-flex justify-content-center align-items-center position-relative">
        <div class="position-relative">
          @if(auth()->user()->image)
          <input type="hidden">
          <img src="{{ asset('storage/' . auth()->user()->image) }}" class="img-preview rounded-circle" style="width: 220px; height: 220px; object-fit: cover;">
          @elseif(!auth()->user()->image)
          <img src="{{ asset('storage/default.jpg') }}" class="img-preview rounded-circle" style="width: 220px; height: 220px; object-fit: cover;">
          @endif
  
          <div class="row mt-4 image-button">
            <div class="col text-center">
              <input type="file" class="position-absolute top-0 end-0 translate-middle p-1 d-none" id="image" name="image" accept="image/*" onchange="previewImage()">
              <label for="image" class="btn btn-outline-primary">Choose Image</label>
              <button type="button" class=" ms-2 btn btn-outline-danger remove-image" style="display: {{ auth()->user()->image ? '' : 'none' }}">Remove Image</button>
            </div>
          </div>
  
        </div>
      </div>

      <div class="col-lg-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="col-lg-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      
      <div class="col-lg-6">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', auth()->user()->username) }}">
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="col-lg-6 change-pw-button">
        <button type="button" class="btn btn-secondary" data-bs-target="#changePasswordModal" data-bs-toggle="modal">
          Change Password
        </button>
      </div>

      <div class="col-lg-6 my-4">
        <button type="submit" class="btn btn-primary" id="updateButton" style="display: none;">
          Update Data
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/profile/change-password/{{ auth()->user()->id }}">
          @csrf
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="currentPassword" name="currentPassword" autofocus required>
              <button class="btn btn-outline-secondary togglePassword" style="border-left: 0px"  type="button">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="newPassword" name="newPassword" required>
              <button class="btn btn-outline-secondary togglePassword" style="border-left: 0px"  type="button">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
              <button class="btn btn-outline-secondary togglePassword" style="border-left: 0px" type="button">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
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

    $('#image').change(function() {
      if ($(this).val()) {
        $('.remove-image').css('display', '');
      } else {
        $('.remove-image').css('display', 'none');
      }
    });

    $('.remove-image').click(function() {
      $('.img-preview').attr('src', '{{ asset('storage/default.jpg') }}');
      $('#image').val('');
      $(this).hide();

      if ($('#updateButton').css('display') === 'none') {
        $('#updateButton').css('display', 'block');
      }
    });

    $('#profileForm input').on('input', function() {
      if ($('#updateButton').css('display') === 'none') {
        $('#updateButton').css('display', 'block');
      }
    });
  });
</script>

@endsection
