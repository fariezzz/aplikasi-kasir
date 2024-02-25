@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Transaction</h3>
  </div>

  @include('partials.alert')

  <a href="/transaction/checkout-now" class="btn btn-primary mb-3">
    <i class="bi bi-cart-check"></i> Checkout Now
  </a> 

  @if($transactions->count())
  <table class="table table-bordered align-middle" id="transaction-table" style="border-color:rgb(194, 194, 194);">
    <thead>
      <tr>
        <th scope="col" class="table-primary align-middle">#</th>
        <th scope="col" class="table-primary align-middle">Code</th>
        <th scope="col" class="table-primary align-middle">Customer</th>
        <th scope="col" class="table-primary align-middle">Product (qty)</th>
        <th scope="col" class="table-primary align-middle">Total Price</th>
        <th scope="col" class="table-primary align-middle">Date</th>
        <th scope="col" class="table-primary align-middle text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
          <tr>
              <th scope="row" class="text-center">{{ $loop->iteration }}</th>
              <td class="text-center">{{ $transaction->code }}</td>
              <td>{{ $transaction->customer->name }}</td>
              <td>
                @foreach(json_decode($transaction->product_id) as $key => $product_id)
                    {{ $products->where('id', $product_id)->first()->name }}({{ json_decode($transaction->quantity)[$key] }})
                    @if(!$loop->last)
                        ,
                    @endif
                @endforeach
              </td>
              <td data-order="{{ $transaction->total_price }}">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
              <td>{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
              <td scope="col">
                <div class="d-flex justify-content-center">
                  <a href="/transaction/invoice/{{ encrypt($transaction->code) }}" class="btn btn-secondary"><i class="bi bi-printer"></i></a>
                  <a href="/transaction/{{ encrypt($transaction->code) }}" class="btn btn-primary ms-1 d-flex align-items-center">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                  @can('admin')
                  <form action="/transaction/{{ $transaction->code }}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger ms-1 deleteButton"><i class="bi bi-trash3"></i></button>
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

<script>
  $(document).ready(function () {
    $('#transaction-table').DataTable({
      "columnDefs": [
        { "type": "num", "targets": 4 },
        { "orderable": false, "targets": 6 }
      ]
    });
  });
</script>
@endsection