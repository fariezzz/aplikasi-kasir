@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>User List</h3>
  </div>

  @include('partials.alert')

  <div class="row justify-content-end mb-4">
    <div class="col-lg-8">
      <form action="/users" method="GET" class="row g-3">
        <div class="col-lg-5">
          <div>
              <select class="form-select" name="role" id="role">
                  <option value="" {{ request('role') == '' ? 'selected' : '' }}>All Roles</option>
                  <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                  <option value="Cashier" {{ request('role') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
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
    <a href="/users/create" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add User</a>
    {{ $users->links() }}
  </div>

  @if($users->count())
  <table class="table table-bordered text-center mb-5" id="users-table" style="border-color:rgb(194, 194, 194);">
    <thead>
      <tr>
        <th scope="col" class="table-primary">#</th>
        <th scope="col" class="table-primary">Name</th>
        <th scope="col" class="table-primary">Email</th>
        <th scope="col" class="table-primary">Username</th>
        <th scope="col" class="table-primary">Role</th>
        <th scope="col" class="table-primary">Registration Date</th>
        <th scope="col" class="table-primary">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $user)
          <tr>
              <th scope="row">{{ $index + $users->firstItem() }}</th>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->username }}</td>
              <td>{{ $user->role }}</td>
              <td>{{ $user->created_at->diffForHumans() }}</td>
              <td scope="col" class="d-flex justify-content-center">
                @if($user->role == 'Cashier')
                <form action="/users/{{ $user->id }}" method="POST">
                  @csrf
                  <button class="btn btn-danger mx-2" id="deleteButton">
                    <i class="bi bi-trash3"></i> Delete
                  </button>
                </form>
                @else
                <span>Not available.</span>
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

@endsection