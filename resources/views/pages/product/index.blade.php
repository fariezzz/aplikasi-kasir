@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Item List</h3>
    </div>

    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show col" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card" style="height: 100%; width: auto">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top h-75" alt="">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title text-center">{{ $product->name }}</h5>
                        <small>Price: Rp. {{ $product->price }}</small>
                    </div>
                    <div class="d-flex justify-content-center col-lg-12 mb-3 w-100">
                        <button type="button" class="btn btn-primary mx-2"><i class="bi bi-eye"></i> Details</button>
                        <a href="/product/{{ $product->code }}/edit">
                            <button type="button" class="btn btn-warning mx-2"><i class="bi bi-pencil-square"></i> Edit</button>
                        </a>
                        <form action="/product/{{ $product->code }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger mx-2" onclick="confirm('Are you sure to delete the item?')"><i class="bi bi-trash3"></i> Delete</button>
                        </form>
                    </div>
                </div> 
            </div>
            @endforeach
        </div>
    </div>

@endsection