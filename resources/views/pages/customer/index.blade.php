@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Customer List</h3>
    </div>

    @include('partials.alert')

    <div class="row justify-content-end">
      <div class="col-md-4">
          <form action="/customer" method="GET">
              <div class="input-group mb-3">
                  <input type="text" class="form-control" style="border-color:rgb(0, 0, 0);" placeholder="Search" name="search" value="{{ request('search') }}">
                  <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
          </form>
      </div>
    </div>

    <a href="/customer/create" class="btn btn-primary mb-2"><i class="bi bi-plus-circle"></i> Add Customer</a>

    @if($customers->count())
    <table class="table table-bordered text-center" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary">#</th>
            <th scope="col" class="table-primary">Name</th>
            <th scope="col" class="table-primary">Address</th>
            <th scope="col" class="table-primary">Contact</th>
            <th scope="col" class="table-primary">Registration Date</th>
            <th scope="col" class="table-primary">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->contact }}</td>
                    <td>{{ $customer->created_at->diffForHumans() }}</td>
                    <td scope="col" class="d-flex">
                      <a href="/customer/{{ $customer->id }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                      <form action="/customer/{{ $customer->id }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger mx-2" id="deleteButton"><i class="bi bi-trash3"></i></button>
                      </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
      @else
      <h3 class="text-center">No data.</h3>
      @endif
      
      <div class="mb-3">
        {{ $customers->links() }}
      </div>
      
@endsection