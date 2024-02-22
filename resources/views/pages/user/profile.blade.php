@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
    <h3>{{ auth()->user()->name}}'s Profile</h3>
  </div>

  @include('partials.alert')

  @if(session()->has('error'))
    <div class="alert alert-warning alert-dismissible fade show col" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  
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
        <input type="text" min="1" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', auth()->user()->username) }}">
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="col-lg-6 mt-5">
        <button type="submit" class="btn btn-primary" id="updateButton" style="display: none;">
          Update Data
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
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
