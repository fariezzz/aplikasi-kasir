@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>{{ $title }}</h3>
    </div>

    @include('partials.alertError')

    @error('total_price')
      <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @enderror
    
    <div class="col-lg-12 container-fluid">
      <a href="/order" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3 myForm" method="POST" action="/order">
        @csrf
        <div class="col-lg-6">
          <label for="customer_id" class="form-label">Customer</label>
          <select class="form-select selectCustomer" name="customer_id" id="customer_id">
            @foreach($customers as $customer)
              @if(old('customer_id') == $customer->id)
                <option value="{{ $customer->id }}" selected>{{ $customer->name }} ({{ $customer->contact }})</option>
              @else
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="row mt-3">
          <div class="col-lg-6">
            <label for="product_id" class="form-label">Product</label>
              <select class="form-select select2" id="product_id">
                @foreach($products as $product)
                  @if($product->stock > 0)
                    <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{ $product->id }}" data-stock="{{ $product->stock }}">{{ $product->name }} - Rp. {{ number_format($product->price, 0, ',', '.') }} (Stock: {{ $product->stock }})</option>
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
              <th scope="col" class="table-primary">Quantity (Changeable)</th>
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

        <div class="row">
          <div class="col-md-12 mb-3">
            <input type="hidden" name="total_price" value="0">
            <button type="submit" class="btn btn-primary submitButton">
              <i class="bi bi-floppy-fill"></i> Save
            </button>
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
</script>

@endsection