@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Edit Item</h3>
    </div>

    @if(session()->has('error'))
      <div class="alert alert-danger alert-dismissible fade show col" role="alert">
      {!! session('error') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <div class="col">
      <a href="/product" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3" method="POST" action="/product/{{ $product->code }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="col-lg-6">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required autofocus>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="price" class="form-label">Price</label>
          <div class="input-group">
            <span class="input-group-text border-dark">Rp</span>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-12">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="col-lg-6">
          <label for="stock" class="form-label">Stock</label>
          <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
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
          <label for="image" class="form-label">Image</label>
          <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
          @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-6">
          <label for="supplier_id" class="form-label">Supplier</label>
            <select class="form-select" name="supplier_id" id="supplier_id">
              @foreach($suppliers as $supplier)
                @if(old('supplier_id', $product->supplier_id) == $supplier->id)
                  <option value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                @else
                  <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endif
              @endforeach
            </select>
        </div>

        <div class="col-lg-12">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-preview img-fluid col-lg-12">
          @else
          <img src="" class="img-preview img-fluid col-lg-12">
          @endif
        </div>

        <div class="col-12 mb-5">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>

      </form>

    </div>
</div>

@endsection