@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Category List</h3>
    </div>

    @include('partials.alert')

    <a href="/category/create" class="btn btn-primary mb-4"><i class="bi bi-plus-circle"></i> Add Category</a>

    @if($categories->count())
        <table class="table table-bordered align-middle text-center" id="category-table" style="border-color:rgb(194, 194, 194);">
          <thead>
            <tr>
              <th scope="col" class="table-primary align-middle text-center">#</th>
              <th scope="col" class="table-primary align-middle text-center">Name</th>
              <th scope="col" class="table-primary align-middle text-center">Total Items</th>
              <th scope="col" class="table-primary align-middle text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
              @foreach($categories as $category)
                <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->product->count() }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                    <a href="/category/{{ $category->slug }}/edit" class="btn btn-warning">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="/category/{{ $category->slug }}" method="POST">
                      @method('delete')
                      @csrf
                      <button class="btn btn-danger mx-2" id="deleteButton">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
          </tbody>
        </table>
        @else
        <h3 class="text-center">No data.</h3>
        @endif

    <script>
      $(document).ready(function () {
        $('#category-table').DataTable();
      });
    </script>
      
@endsection