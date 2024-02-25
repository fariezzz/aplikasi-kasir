@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Customer List</h3>
  </div>

  @include('partials.alert')

  @include('partials.alertError')

  <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addCustomer">
    <i class="bi bi-plus-circle"></i> Add Customer
  </button>

  @if($customers->count())
  <table class="table table-bordered align-middle" id="customer-table" style="border-color:rgb(194, 194, 194);">
    <thead>
      <tr>
        <th scope="col" class="table-primary align-middle">#</th>
        <th scope="col" class="table-primary align-middle">Name</th>
        <th scope="col" class="table-primary align-middle">Contact</th>
        <th scope="col" class="table-primary align-middle">Address</th>
        <th scope="col" class="table-primary align-middle">Registration Date</th>
        <th scope="col" class="table-primary align-middle text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
            <tr>
              <td scope="row" class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $customer->name }}</td>
              <td>{{ $customer->contact }}</td>
              <td>{{ $customer->address }}</td>
              <td>{{ $customer->created_at->format('Y-m-d H:i:s') }}</td>
              <td scope="col">
                <div class="d-flex justify-content-center">
                  <button href="/customer/{{ $customer->id }}/edit" class="btn btn-warning d-flex align-items-center" data-bs-target="#editCustomer{{ $customer->id }}" data-bs-toggle="modal">
                    <i class="bi bi-pencil-square @can('cashier') me-1 @endcan"></i>{{ auth()->user()->role == 'Admin' ? '' : 'Edit' }}
                  </button>

                  <div class="modal fade" id="editCustomer{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editCustomerLabel">Add Customer</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form class="myForm" method="POST" action="/customer/{{ $customer->id }}">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required>
                            </div>
                            <div class="mb-3">
                              <label for="contact" class="form-label">Contact</label>
                              <input type="text" class="form-control" id="contact" name="contact" value="{{ $customer->contact }}" required>
                            </div>
                            <div class="mb-3">
                              <label for="address" class="form-label">Address</label>
                              <textarea class="form-control" id="address" name="address" required>{{ $customer->address }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary submitButton">Edit Customer</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  @can('admin')
                  <form action="/customer/{{ $customer->id }}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger mx-2 deleteButton"><i class="bi bi-trash3"></i></button>
                  </form>
                  @endcan
                </div>
              </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  @else
  <h3 class="text-center">No data.</h3>
  @endif
</div>

<div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCustomerLabel">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="myForm" method="POST" action="/customer">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary submitButton">Add Customer</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#customer-table').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 5 }
      ]
    });
  });
</script>
      
@endsection