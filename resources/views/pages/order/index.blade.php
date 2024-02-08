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

    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Code</th>
            <th scope="col">Customer</th>
            <th scope="col">Product</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
              @if($order->transaction->status == 'Pending')
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->transaction->status }}</td>
                    <td class="col">
                      <button type="button" class="btn btn-success change-status" data-transaction-id="{{ $order->transaction->id }}"><i class="bi bi-check2"></i></button>
                      <button type="button" class="btn btn-danger change-status" data-transaction-id="{{ $order->transaction->id }}"><i class="bi bi-x-lg"></i></button>
                    </td>
                </tr>
              @endif
            @endforeach
        </tbody>
      </table>

      <script>
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
    </script>

@endsection