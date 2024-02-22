@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
    <h3>Pay Order</h3>
  </div>

  <div class="col-lg-12 container-fluid">
    @include('partials.alertError')

    <a href="/order" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
    
    <table class="table table-bordered mb-3 text-center" style="border-color:rgb(194, 194, 194);">
      <thead>
        <tr>
            <th scope="col" class="table-primary">Customer</th>
            <th scope="col" class="table-primary">Product</th>
            <th scope="col" class="table-primary">Quantity</th>
            <th scope="col" class="table-primary">Price</th>
            <th scope="col" class="table-primary">Total</th>
        </tr>
        </thead>
        <tbody>
          @php
            $rowspan = count(json_decode($order->product_id));
          @endphp
          @foreach(json_decode($order->product_id) as $key => $product_id)
            <tr>
                @if($key === 0)
                <td rowspan="{{ $rowspan }}">{{ $order->customer->name }}</td>
                @endif
                <td>{{ $products->where('id', $product_id)->first()->name }}</td>
                <td>{{ json_decode($order->quantity)[$key] }}</td>
                <td>Rp. {{ number_format($products->where('id', $product_id)->first()->price, 0, ',', ',') }}</td>
                <td>Rp. {{ number_format(json_decode($order->quantity)[$key] * $products->where('id', $product_id)->first()->price, 0, ',', ',') }}</td>
            </tr>
          @endforeach
        </tbody>
    </table>

    <form method="POST" action="/transaction/pay/{{ $order->code }}" class="myForm">
      @csrf
      <div class="row mt-3">
        <div class="col-lg-3">
            <label for="total_price" class="form-label">Total Price</label>
            <div class="input-group flex-nowrap">
              <span class="input-group-text" id="addon-wrapping" style="border-color:black">Rp.</span>
              <input type="text" class="form-control" id="total_price" name="total_price" aria-describedby="addon-wrapping" value="{{ number_format($order->total_price, 0, '', '') }}" readonly>
            </div>
        </div>

        <div class="col-lg-3">
          <label for="amount_paid" class="form-label">Amount Paid</label>
          <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping" style="border-color:black">Rp.</span>
            <input type="number" class="form-control" id="amount_paid" name="amount_paid" calculateChange() aria-describedby="addon-wrapping" value="0" required>
          </div>
        </div>

        <div class="col-lg-3">
          <label for="change" class="form-label">Change</label>
          <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping" style="border-color:black">Rp.</span>
            <input type="text" class="form-control" id="change" name="change" aria-describedby="addon-wrapping" value="0" required readonly>
          </div>
        </div>
      </div>

      <div class="row mt-4 mb-5">
        <div class="col-lg-12">
          <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
          @foreach(json_decode($order->product_id) as $index => $product_id)
              <input type="hidden" name="product_id[]" value="{{ $product_id }}">
              <input type="hidden" name="quantity[]" value="{{ json_decode($order->quantity)[$index] }}">
          @endforeach
          <input type="hidden" name="total_price" value="{{ $order->total_price }}">
          <button type="submit" class="btn btn-primary submitButton">
            <i class="bi bi-credit-card-fill"></i> Pay
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function calculateChange() {
      let totalPrice = parseFloat(document.getElementById('total_price').value.replace(/\./g, '').replace(',', '.'));
      let amountPaid = parseFloat(document.getElementById('amount_paid').value.replace(/\./g, '').replace(',', '.'));
      let change = amountPaid - totalPrice;

      document.getElementById('change').value = change;
  }

  document.getElementById('amount_paid').addEventListener('input', calculateChange);
</script>

@endsection