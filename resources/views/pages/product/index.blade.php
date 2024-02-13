@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Item List</h3>
    </div>

    @include('partials.alert')

    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-lg-8">
                <form action="/product" method="GET" class="row g-3">
                    <div class="col-lg-5">
                        <div>
                            <select class="form-select" name="category" id="category">
                                <option value="" selected>All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="input-group">
                            <input type="text" class="form-control" style="border-color:rgb(0, 0, 0);" placeholder="Search name..." name="search" value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-lg-2 d-flex justify-content-between align-self-center">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col">
            <a href="/product/create" class="btn btn-primary mb-3">Add Item</a>
            {{ $products->links() }}
        </div>
        
        <div class="row">
            @if($products->count())
                @foreach ($products as $product)
                    <div class="col-md-4 mb-3">
                        <div class="card" style="height: 100%; width: auto">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top h-75" alt="">

                            <div class="card-body d-flex flex-column align-items-center">
                                <h5 class="card-title text-center">{{ $product->name }}</h5>
                                <small>Price: Rp. {{ $product->price }}</small>
                                <small>Stock: {{ $product->stock }}</small>
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
            @else
            <h3 class="text-center">No data.</h3>
            @endif
        </div>
    </div>

@endsection