@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Customer List</h3>
    </div>

    @include('partials.alert')

    <a href="/customer/create" class="btn btn-primary mb-4"><i class="bi bi-plus-circle"></i> Add Customer</a>

    @if($customers->count())
    <table class="table table-bordered align-middle" id="customer-table" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary align-middle">#</th>
            <th scope="col" class="table-primary align-middle">Name</th>
            <th scope="col" class="table-primary align-middle">Contact</th>
            <th scope="col" class="table-primary align-middle">Address</th>
            <th scope="col" class="table-primary align-middle">Registration Date</th>
            <th scope="col" class="table-primary align-middle">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->contact }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->created_at->diffForHumans() }}</td>
                    <td scope="col">
                      <div class="d-flex">
                        <a href="/customer/{{ $customer->id }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="/customer/{{ $customer->id }}" method="POST">
                          @method('delete')
                          @csrf
                          <button class="btn btn-danger mx-2" id="deleteButton"><i class="bi bi-trash3"></i></button>
                        </form>
                      </div>
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
          $('#customer-table').DataTable();
        });
      </script>
      
@endsection