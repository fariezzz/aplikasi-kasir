@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Add Transaction</h3>
    </div>

    <div class="col-lg-12 container-fluid">
      @if(session()->has('error'))
      <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if($unselectedOrders->where('status', 'Pending')->count() > 0)
      <h5>Select Order</h5>
      <table class="table table-bordered mb-3" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary">#</th>
            <th scope="col" class="table-primary">Code</th>
            <th scope="col" class="table-primary">Customer</th>
            <th scope="col" class="table-primary">Product</th>
            <th scope="col" class="table-primary">Quantity</th>
            <th scope="col" class="table-primary">Total</th>
            <th scope="col" class="table-primary">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($unselectedOrders as $order)
             @if($order->status == 'Pending')
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $order->code }}</td>
                  <td>{{ $order->customer->name }}</td>
                  <td>{{ $order->product->name }}</td>
                  <td>{{ $order->quantity }}</td>
                  <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                      <form action="{{ route('add.selected.order', $order->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-success">Add to Selected Order</button>
                      </form>
                  </td>
                </tr>
              @endif
            @endforeach
        </tbody>
      </table>
      @else
      <div class="text-center mb-3">
        <h5>There are no orders left. Add an order <a href="/order/create" style="text-decoration-line:underline">here.</a></h5>
      </div>
      @endif

      @if(!$selectedOrders->isEmpty())
      <h5 class="mt-4">Selected Order</h5>
      <table class="table table-bordered" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col" class="table-primary">#</th>
            <th scope="col" class="table-primary">Code</th>
            <th scope="col" class="table-primary">Customer</th>
            <th scope="col" class="table-primary">Product</th>
            <th scope="col" class="table-primary">Quantity</th>
            <th scope="col" class="table-primary">Total</th>
            <th scope="col" class="table-primary">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($selectedOrders as $selectedOrder)
              <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $selectedOrder->code }}</td>
                  <td>{{ $selectedOrder->customer->name }}</td>
                  <td>{{ $selectedOrder->product->name }}</td>
                  <td>{{ $selectedOrder->quantity }}</td>
                  <td>Rp. {{ number_format($selectedOrder->total_price, 0, ',', '.') }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                      <form action="{{ route('remove.selected.order', $selectedOrder->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-danger">Remove from Selected Order</button>
                      </form>
                  </td>
              </tr>
            @endforeach
        </tbody>
      </table>

      <div class="row mt-3">
        <div class="col-lg-3">
            <label for="total_price" class="form-label">Total Price</label>
            <div class="input-group flex-nowrap">
              <span class="input-group-text" id="addon-wrapping" style="border-color:black">Rp.</span>
              <input type="text" class="form-control" id="total_price" name="total_price" aria-describedby="addon-wrapping" value="{{ $selectedOrders->sum('total_price') }}">
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
            <form method="POST" action="/transaction">
                @csrf
                <button type="submit" class="btn btn-primary">Store Transaction</button>
            </form>
        </div>
      </div>
    @endif
  </div>
</div>

<script>
  function calculateChange() {
      let totalPrice = parseFloat(document.getElementById('total_price').value);
      let amountPaid = parseFloat(document.getElementById('amount_paid').value);
      let change = amountPaid - totalPrice;

      document.getElementById('change').value = change;
  }

  document.getElementById('amount_paid').addEventListener('input', calculateChange);
</script>

@endsection