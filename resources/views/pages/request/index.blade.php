@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>{{ $title }}</h3>
  </div>

  @include('partials.alert')

  {{-- <div class="row justify-content-end mb-2"> --}}
    {{-- <div class="col-lg-9">
      <a href="/users/create" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add User</a>
    </div> --}}
    {{-- <div class="col-lg-3">
      <form action="/requests" method="GET" class="row">
        <div class="col-lg-12">
          <select class="form-select" name="status" id="status">
              <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
              <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
              <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
              <option value="Denied" {{ request('status') == 'Denied' ? 'selected' : '' }}>Denied</option>
          </select>
        </div>
      </form>
    </div>
  </div> --}}

  @if($requests->where('status', 'Pending')->count())
  <table class="table table-bordered align-middle" id="request-table" style="border-color:rgb(194, 194, 194);">
    <thead>
        <tr>
            <th scope="col" class="table-primary text-center align-middle">#</th>
            <th scope="col" class="table-primary align-middle">Name</th>
            <th scope="col" class="table-primary align-middle">Email</th>
            <th scope="col" class="table-primary align-middle">Username</th>
            <th scope="col" class="table-primary align-middle">Role</th>
            <th scope="col" class="table-primary align-middle text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
      @foreach($requests as $request)
        @if($request->status == 'Pending')
        <tr>
            <th scope="row" class="text-center">{{ $loop->iteration }}</th>
            <td>{{ $request->name }}</td>
            <td>{{ $request->email }}</td>
            <td>{{ $request->username }}</td>
            <td class="text-center">{{ $request->role }}</td>
            <td scope="col" class="justify-content-center text-center">
              <button type="button" class="btn btn-primary btn-detail" data-bs-toggle="modal" data-bs-target="#requestDetails{{ $request->id }}" data-name="{{ $request->name }}" data-email="{{ $request->email }}" data-role="{{ $request->role }}" data-reasons="{{ $request->reasons }}" data-status="{{ $request->status }}" data-username="{{ $request->username }}">
                  <i class="bi bi-eye"></i> Details
              </button>

              <div class="modal fade text-start" id="requestDetails{{ $request->id }}" tabindex="-1" aria-labelledby="requestDetails{{ $request->id }}Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="requestDetails{{ $request->id }}Label">Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <p><strong>Name:</strong> <span id="detailName"></span></p>
                          <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                          <p><strong>Username:</strong> <span id="detailUsername"></span></p>
                        </div>
                        <div class="col-md-6">
                          <p><strong>Role:</strong> <span id="detailRole"></span></p>
                          <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                          <p><strong>Reasons:</strong> <span id="detailReasons"></span></p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                      <form class="myForm" action="account-requests/{{ $request->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Denied">
                        <button type="submit" class="btn btn-danger submitButton" data-dismiss="modal">Deny</button>
                      </form>
                      <form class="myForm" action="account-requests/{{ $request->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Accepted">
                        <button type="submit" class="btn btn-success submitButton">Accept</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
        </tr>
        @endif
      @endforeach
    </tbody>
  </table>
  @else
    <h3 class="text-center mt-4">No data.</h3>
  @endif
</div>

<script>
  $(document).ready(function () {
    $('#request-table').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 5 }
      ]
    });

    $('#role').change(function() {
      let status = $(this).val();
      window.location.href = `/requests?status=${status}`;
    });

    $(document).ready(function() {
      $('.btn-detail').click(function() {
        let name = $(this).data('name');
        let email = $(this).data('email');
        let username = $(this).data('username');
        let role = $(this).data('role');
        let status = $(this).data('status');
        let reasons = $(this).data('reasons');

        $('#detailName').text(name);
        $('#detailEmail').text(email);
        $('#detailUsername').text(username);
        $('#detailRole').text(role);
        $('#detailStatus').text(status);
        $('#detailReasons').text(reasons);

        $('#detailsModal').modal('show');
      });
    });
  });
</script>

@endsection