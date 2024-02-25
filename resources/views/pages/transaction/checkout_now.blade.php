@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>{{ $title }}</h3>
    </div>

    @if(session()->has('error'))
      <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! session('error') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <div class="col-lg-12 container-fluid">
      <a href="/transaction" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3" method="POST" action="/transaction/pay-now">
        @csrf
        <div class="col-lg-6">
          <label for="customer_id" class="form-label">Customer</label>
          <select class="form-select selectCustomer" name="customer_id" id="customer_id">
            @foreach($customers as $customer)
              @if(old('customer_id') == $customer->id)
                <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
              @else
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="row mt-3">
          <div class="col-lg-6">
            <label for="product_id" class="form-label">Product</label>
              <select class="form-control select2" name="product_id" id="product_id">
                @foreach($products as $product)
                  @if($product->stock > 0)
                    <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" data-id="{{ $product->id }}">{{ $product->name }} (Rp. {{ number_format($product->price) }})</option>
                  @endif
                @endforeach
              </select>
          </div>
  
          <div class="col-lg-4">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-primary d-block mt-2" onclick="addItem()">
              <i class="bi bi-plus-circle"></i> Add Item
            </button>
          </div>
        </div>

        <table class="table table-bordered text-center" style="border-color:rgb(194, 194, 194);">
          <thead>
            <tr>
              <th scope="col" class="table-primary">#</th>
              <th scope="col" class="table-primary">Product</th>
              <th scope="col" class="table-primary">Quantity</th>
              <th scope="col" class="table-primary">Price</th>
              <th scope="col" class="table-primary">Actions</th>
            </tr>
          </thead>
          <tbody class="items">
              
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2">Total</th>
              <th class="quantity"></th>
              <th class="totalPrice"></th>
              <th></th>
            </tr>
          </tfoot>
        </table>

        <div class="row mb-3">
          <div class="col-lg-3">
              <label for="total_price" class="form-label">Total Price</label>
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping" style="border-color:black">Rp.</span>
                <input type="text" class="form-control" id="totalPrice" name="total_price" aria-describedby="addon-wrapping" value="0" readonly>
              </div>
          </div>
  
          <div class="col-lg-3">
            <label for="amount_paid" class="form-label">Amount Paid</label>
            <div class="input-group flex-nowrap">
              <span class="input-group-text" id="addon-wrapping" style="border-color:black">Rp.</span>
              <input type="number" class="form-control" id="amount_paid" name="amount_paid" calculateChange() aria-describedby="addon-wrapping" value="" required>
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

        <div class="row">
          <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-credit-card-fill"></i> Pay</button>
          </div>
        </div>

      </form>

    </div>
</div>

<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
  
  $(document).ready(function() {
    $('.selectCustomer').select2();
  });
  
  function calculateChange() {
    let totalPrice = parseFloat(document.getElementById('totalPrice').value.replace(/\./g, '').replace(',', '.'));
    let amountPaid = parseFloat(document.getElementById('amount_paid').value.replace(/\./g, '').replace(',', '.'));
    let change = amountPaid - totalPrice;

    document.getElementById('change').value = change;
  }

  document.getElementById('amount_paid').addEventListener('input', calculateChange);
</script>

@endsection