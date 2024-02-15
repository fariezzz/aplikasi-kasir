@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Order List</h3>
    </div>

    @include('partials.alert')

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
      <a href="/order/create" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add Order</a>
      {{ $orders->links() }}
    </div>

    @if($orders->count())
    <table class="table table-bordered text-center" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary">#</th>
            <th scope="col" class="table-primary">Code</th>
            <th scope="col" class="table-primary">Customer</th>
            <th scope="col" class="table-primary">Product (qty)</th>
            <th scope="col" class="table-primary">Total</th>
            <th scope="col" class="table-primary">Status</th>
            <th scope="col" class="table-primary">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
              <tr>
                  <th scope="row">{{ $index + $orders->firstItem() }}</th>
                  <td>{{ $order->code }}</td>
                  <td>{{ $order->customer->name }}</td>
                  <td>
                    @foreach(json_decode($order->product_id) as $key => $product_id)
                      {{ $products->where('id', $product_id)->first()->name }}({{ json_decode($order->quantity)[$key] }})
                      @if(!$loop->last)
                          <br>
                      @endif
                    @endforeach
                  </td>
                  <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                  <td>{{ $order->status }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                    @if($order->status == 'Done' || $order->status == 'Cancelled')
                    <form action="/order/{{ $order->id }}" method="POST">
                      @method('delete')
                      @csrf
                      <button class="btn btn-danger mx-2" id="deleteButton">
                        <i class="bi bi-trash3"></i> Delete
                      </button>
                    </form>
                    @else
                    <a href="/transaction/pay-order/{{ $order->code }}" class="btn btn-primary">
                      <i class="bi bi-credit-card-fill"></i> Pay
                    </a>
                    <form action="/order/{{ $order->id }}" method="POST">
                      @method('put')
                      @csrf
                      <button class="btn btn-danger mx-2" id="cancelButton">
                        <i class="bi bi-x-circle"></i> Cancel
                      </button>
                    </form>
                    @endif
                  </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      @else
        <h3 class="text-center">No data.</h3>
      @endif

@endsection