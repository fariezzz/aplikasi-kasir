@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Transaction</h3>
    </div>

    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show col" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="row justify-content-end mb-4">
      <div class="col-lg-8">
          <form action="/order" method="GET" class="row g-3">
              <div class="col-lg-5">
                  <div>
                      <select class="form-select" name="status" id="status">
                          <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Statuses</option>
                          <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                          <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                          <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                      </select>
                  </div>
              </div>

              <div class="col-lg-5">
                  <div class="input-group">
                      <input type="text" class="form-control" style="border-color:rgb(0, 0, 0);" placeholder="Search customer..." name="search" value="{{ request('search') }}">
                  </div>
              </div>

              <div class="col-lg-2 d-flex justify-content-between align-self-center">
                  <button class="btn btn-primary" type="submit">Search</button>
              </div>
          </form>
      </div>
    </div>

    <div class="col">
      <a href="/transaction/create" class="btn btn-primary mb-3">Add Transaction</a>
    </div>

    <table class="table table-bordered" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary">#</th>
            <th scope="col" class="table-primary">Code</th>
            <th scope="col" class="table-primary">Customer</th>
            <th scope="col" class="table-primary">Product</th>
            <th scope="col" class="table-primary">Total Price</th>
            <th scope="col" class="table-primary">Date</th>
            <th scope="col" class="table-primary">Status</th>
            <th scope="col" class="table-primary">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
              <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $transaction->code }}</td>
                  <td>{{ $transaction->customer->name }}</td>
                  <td>
                    @if($transaction->orders->count())
                      @foreach ($transaction->orders as $index => $order)
                          {{ $order->product->name . '(' . $order->quantity . ')' }}
                          @if ($index < $transaction->orders->count() - 1)
                              ,
                          @endif
                      @endforeach
                    @else
                      No items
                    @endif
                  </td>
                  <td>Rp. {{ number_format($transaction->orders->sum('total_price'), 0, ',', '.') }}</td>
                  <td>{{ $transaction->date }}</td>
                  <td>{{ $transaction->status }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                    @if($transaction->status == 'Pending')
                      <a href="/transaction/{{ $transaction->code }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right"></i>
                         Proceed
                      </a>
                    @else
                      <form action="/transaction/{{ $transaction->code }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger mx-2" onclick="confirm('Are you sure to delete the transaction?')"><i class="bi bi-trash3"></i> Delete</button>
                      </form>
                    @endif
                  </td>
              </tr>
            @endforeach
        </tbody>
      </table>

@endsection