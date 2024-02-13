@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Add Order</h3>
    </div>
    
    <div class="col-lg-12 container-fluid">
      <form class="row g-3" method="POST" action="/order">
        @csrf
        <div class="col-lg-6">
          <label for="customer_id" class="form-label">Customer ID</label>
            <select class="form-select" name="customer_id" id="customer_id">
              @foreach($customers as $customer)
                @if(old('customer_id') == $customer->id)
                  <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                @else
                  <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endif
              @endforeach
            </select>
        </div>

        <div class="col-lg-6">
          <label for="product_id" class="form-label">Product</label>
            <select class="form-select" name="product_id" id="product_id" required>
              @foreach($products as $product)
                @if(old('product_id') == $product->id)
                  <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                @else
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endif
              @endforeach
            </select>
        </div>

        <div class="col-lg-6">
          <label for="quantity" class="form-label">Quantity</label>
          <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1 ) }}" required>
          @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="total_price" class="form-label">Total Price</label>
          <input type="number" min="1" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" value="{{ old('total_price') }}" required readonly>
          @error('total_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
</div>

<script>
  function calculateTotalPrice() {
    let productId = document.getElementById('product_id').value;
    let quantityInput = document.getElementById('quantity');
    let quantity = quantityInput.value;

    let product = @json($products->toArray());

    let selectedProduct = product.find(function(prod) {
        return prod.id == productId;
    });

    if (!selectedProduct) {
        return;
    }

    quantityInput.setAttribute('max', selectedProduct.stock);

    if (quantity > selectedProduct.stock) {
        quantityInput.value = selectedProduct.stock;
        quantity = selectedProduct.stock;
    }

    let totalPrice = selectedProduct.price * quantity;

    document.getElementById('total_price').value = totalPrice;
}

document.getElementById('product_id').addEventListener('change', calculateTotalPrice);
document.getElementById('quantity').addEventListener('input', calculateTotalPrice);

calculateTotalPrice();

</script>

@endsection