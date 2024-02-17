@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>User List</h3>
  </div>

  @include('partials.alert')

  <div class="row justify-content-between mb-2">
    <div class="col-lg-9">
      <a href="/users/create" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add User</a>
    </div>
    <div class="col-lg-3">
      <form action="/users" method="GET" class="row">
        <div class="col-lg-12">
          <select class="form-select" name="role" id="role">
              <option value="" {{ request('role') == '' ? 'selected' : '' }}>All Roles</option>
              <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
              <option value="Cashier" {{ request('role') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
          </select>
        </div>
      </form>
    </div>
  </div>

  @if($users->count())
  <table class="table table-bordered mb-5 align-middle" id="user-table" style="border-color:rgb(194, 194, 194);">
    <thead>
        <tr>
            <th scope="col" class="table-primary text-center align-middle">#</th>
            <th scope="col" class="table-primary align-middle">Name</th>
            <th scope="col" class="table-primary align-middle">Email</th>
            <th scope="col" class="table-primary align-middle">Username</th>
            <th scope="col" class="table-primary align-middle">Role</th>
            <th scope="col" class="table-primary align-middle">Registration Date</th>
            <th scope="col" class="table-primary align-middle">Actions</th>
        </tr>
    </thead>
    <tbody>
      @foreach($users as $index => $user)
      <tr>
          <th scope="row" class="text-center">{{ $loop->iteration }}</th>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->username }}</td>
          <td>{{ $user->role }}</td>
          <td>{{ $user->created_at->diffForHumans() }}</td>
          <td scope="col" class="justify-content-center text-center">
            @if($user->role == 'Cashier')
            <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger" id="deleteButton">
              <i class="bi bi-trash3"></i>
            </a>
            @else
            <span>-</span>
            @endif
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <h3 class="text-center">No data.</h3>
  @endif
</div>

<script>
  $(document).ready(function () {
    $('#user-table').DataTable();

    $('#role').change(function() {
      let role = $(this).val();
      window.location.href = `/users?role=${role}`;
    });
  });
</script>

@endsection