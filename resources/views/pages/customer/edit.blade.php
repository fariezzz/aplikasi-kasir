@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Edit Customer</h3>
    </div>
    
    <div class="col-lg-12 container-fluid">
      <form class="row g-3" method="POST" action="/customer/{{ $customer->id }}">
        @method('put')
        @csrf
        <div class="col-lg-6">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->name) }}" required autofocus>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-12">
          <label for="address" class="form-label">Address</label>
          <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" required>{{ old('address', $customer->address) }}</textarea>
          @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="contact" class="form-label">Phone Number</label>
          <input type="tel" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact', $customer->contact) }}" required>
          @error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>

      </form>

    </div>
</div>

@endsection