@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Category List</h3>
    </div>

    @include('partials.alert')

    <a href="/category/create" class="btn btn-primary mb-2">Add Category</a>

    <div class="row text-center">
      <div class="col-lg-12">
        @if($categories->count())
        <table class="table table-bordered" style="border-color:rgb(194, 194, 194);">
          <thead>
            <tr>
              <th scope="col" class="table-primary">#</th>
              <th scope="col" class="table-primary">Name</th>
              <th scope="col" class="table-primary">Total Items</th>
              <th scope="col" class="table-primary">Actions</th>
            </tr>
          </thead>
          <tbody>
              @foreach($categories as $category)
                  <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>{{ $category->name }}</td>
                      <td>{{ $category->product->count() }}</td>
                      <td scope="col" class="d-flex justify-content-center">
                        <a href="/category/{{ $category->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="/category/{{ $category->slug }}" method="POST">
                          @method('delete')
                          @csrf
                          <button class="btn btn-danger mx-2" onclick="confirm('Are you sure to delete the item?')"><i class="bi bi-trash3"></i></button>
                        </form>
                      </td>
                  </tr>
              @endforeach
          </tbody>
        </table>
        @else
        <h3 class="text-center">No data.</h3>
        @endif
      </div>
    </div>
      
@endsection