@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>{{ $title }}</h3>
  </div>

  @include('partials.alert')

  <a href="/suppliers/create" class="btn btn-primary mb-4"><i class="bi bi-plus-circle"></i> Add Supplier</a>

  @if($suppliers->count())
  <table class="table table-bordered align-middle" id="supplier-table" style="border-color:rgb(194, 194, 194);">
    <thead>
      <tr>
        <th scope="col" class="table-primary align-middle">#</th>
        <th scope="col" class="table-primary align-middle">Name</th>
        <th scope="col" class="table-primary align-middle">Email</th>
        <th scope="col" class="table-primary align-middle">Contact</th>
        <th scope="col" class="table-primary align-middle">Address</th>
        <th scope="col" class="table-primary align-middle">Date Joined</th>
        <th scope="col" class="table-primary align-middle text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($suppliers as $supplier)
        <tr>
          <td scope="row" class="text-center">{{ $loop->iteration }}</td>
          <td>{{ $supplier->name }}</td>
          <td>{{ $supplier->email }}</td>
          <td>{{ $supplier->contact }}</td>
          <td>{{ $supplier->address }}</td>
          <td>{{ $supplier->created_at->format('Y-m-d H:i:s') }}</td>
          <td scope="col">
            <div class="d-flex">
              <button type="button" class="btn btn-primary mx-2 btn-detail" data-name="{{ $supplier->name }}" data-email="{{ $supplier->email }}" data-description="{{ $supplier->description }}" data-contact="{{ $supplier->contact }}" data-address="{{ $supplier->address }}" data-joined-date="{{ $supplier->created_at->format('Y-m-d H:i:s') }}"><i class="bi bi-eye"></i></button>

              <a href="/suppliers/{{ encrypt($supplier->id) }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>

              <form action="/suppliers/{{ $supplier->id }}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger mx-2 deleteButton"><i class="bi bi-trash3"></i></button>
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
</div>

<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Supplier Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Name:</strong> <span id="detailName"></span></p>
              <p><strong>Email:</strong> <span id="detailEmail"></span></p>
              <p><strong>Contact:</strong> <span id="detailContact"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Address:</strong> <span id="detailAddress"></span></p>
              <p><strong>Joined Date:</strong> <span id="detailJoinedDate"></span></p>
              <p><strong>Description:</strong> <span id="detailDescription"></span></p>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#supplier-table').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 6 }
      ]
    });
  });
  
  $(document).ready(function() {
    $('.btn-detail').click(function() {
      let name = $(this).data('name');
      let email = $(this).data('email');
      let contact = $(this).data('contact');
      let address = $(this).data('address');
      let joinedDate = $(this).data('joined-date');
      let description = $(this).data('description');

      $('#detailName').text(name);
      $('#detailEmail').text(email);
      $('#detailContact').text(contact);
      $('#detailAddress').text(address);
      $('#detailJoinedDate').text(joinedDate);
      $('#detailDescription').text(description);

      $('#detailsModal').modal('show');
    });
  });
</script>
      
@endsection