@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Add Category</h3>
    </div>
    
    <div class="col-lg-12 container-fluid">
      <a href="/category" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form method="POST" action="/category" class="myForm">
        @csrf
        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" required>
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary submitButton">Add</button>
        </div>

      </form>

    </div>
</div>

<script>
    const name = document.querySelector("#name");
    const slug = document.querySelector("#slug");

    name.addEventListener("keyup", function() {
        let preslug = name.value;
        preslug = preslug.replace(/ /g,"-");
        slug.value = preslug.toLowerCase();
    });
</script>

@endsection