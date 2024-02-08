@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show col" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Edit Item</h3>
    </div>
    
    <div class="col">

      <form class="row g-3" method="POST" action="/product/{{ $product->id }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="col-lg-6">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required autofocus>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="code" class="form-label">Code</label>
          <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $product->code) }}" required autofocus>
          @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description', $product->description) }}"></textarea>
        </div>

        <div class="col-lg-6">
          <label for="stock" class="form-label">Stock</label>
          <input type="number" min="1" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
          @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="category_id" class="form-label">Category</label>
            <select class="form-select" name="category_id" id="category_id">
              @foreach($categories as $category)
                @if(old('category_id', $product->category_id) == $category->id)
                  <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @else
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
              @endforeach
            </select>
        </div>

        <div class="col-lg-6">
          <label for="price" class="form-label">Price</label>
          <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required autofocus>
          @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="image" class="form-label">Image</label>
          <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
          @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-12">
          <img src="{{ asset('storage/' . $product->image) }}" class="img-preview img-fluid mb-3 col-lg-12">
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>

      </form>

    </div>
</div>

@endsection