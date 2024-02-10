@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Order List</h3>
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
      <a href="/order/create" class="btn btn-primary mb-3">Add Order</a>
      {{ $orders->links() }}
    </div>

    <table class="table table-bordered" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary">#</th>
            <th scope="col" class="table-primary">Code</th>
            <th scope="col" class="table-primary">Customer</th>
            <th scope="col" class="table-primary">Product</th>
            <th scope="col" class="table-primary">Quantity</th>
            <th scope="col" class="table-primary">Total</th>
            <th scope="col" class="table-primary">Status</th>
            <th scope="col" class="table-primary">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
              <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $order->code }}</td>
                  <td>{!! $order->customer->name . '<br>(' . $order->transaction->code . ')' !!}</td>
                  <td>{{ $order->product->name }}</td>
                  <td>{{ $order->quantity }}</td>
                  <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                  <td>{{ $order->transaction->status }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                    @if($order->transaction->status == 'Pending')
                      <span>Not available</span>
                      {{-- <a href="/transaction/{{ $order->transaction->code }}" class="btn btn-primary">
                        <i class="bi bi-cash"></i>
                         Pay
                      </a> --}}
                    @else
                      <form action="/order/{{ $order->id }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger mx-2" onclick="confirm('Are you sure to delete the order?')"><i class="bi bi-trash3"></i> Delete</button>
                      </form>
                    @endif
                  </td>
              </tr>
            @endforeach
        </tbody>
      </table>

      {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
          let changeStatusButtons = document.querySelectorAll('.change-status');
          
          changeStatusButtons.forEach(button => {
            button.addEventListener('click', function() {
                let transactionId = this.getAttribute('data-transaction-id');
                let newStatus = this.classList.contains('btn-success') ? 'Done' : 'Cancelled';
                changeTransactionStatus(transactionId, newStatus);
            });
          });

          function changeTransactionStatus(transactionId, newStatus) {
            fetch(`/change-status/${transactionId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                location.reload();
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
          }
        });
    </script> --}}

@endsection