@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Transaction</h3>
  </div>

  @include('partials.alert')

  <a href="/transaction/checkout-now" class="btn btn-primary mb-3">
    <i class="bi bi-cart-check"></i> Checkout Now
  </a> 

  @if($transactions->count())
  <table class="table table-bordered text-center" id="transaction-table" style="border-color:rgb(194, 194, 194);">
      <thead>
        <tr>
          <th scope="col" class="table-primary">#</th>
          <th scope="col" class="table-primary">Code</th>
          <th scope="col" class="table-primary">Customer</th>
          <th scope="col" class="table-primary">Product (qty)</th>
          <th scope="col" class="table-primary">Total Price</th>
          <th scope="col" class="table-primary">Date</th>
          <th scope="col" class="table-primary">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach($transactions as $index => $transaction)
            <tr>
                <th scope="row">{{ $index + $transactions->firstItem() }}</th>
                <td>{{ $transaction->code }}</td>
                <td>{{ $transaction->customer->name }}</td>
                <td>
                  @foreach(json_decode($transaction->product_id) as $key => $product_id)
                      {{ $products->where('id', $product_id)->first()->name }}({{ json_decode($transaction->quantity)[$key] }})
                      @if(!$loop->last)
                          <br>
                      @endif
                  @endforeach
                </td>
                <td>Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
                <td scope="col">
                  <div class="d-flex justify-content-center">
                    <a href="/transaction/{{ $transaction->code }}" class="btn btn-primary mx-2" ><i class="bi bi-eye-fill"></i></a>
                    <form action="/transaction/{{ $transaction->code }}" method="POST">
                      @method('delete')
                      @csrf
                      <button class="btn btn-danger mx-2" id="deleteButton"><i class="bi bi-trash3"></i></button>
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
    {{ $transactions->appends(request()->input())->links() }}
</div>

<script>
  $(document).ready(function () {
    $('#transaction-table').DataTable();
  });
</script>
@endsection