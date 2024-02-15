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

        <div class="row mt-3">
          <div class="col-lg-6">
            <label for="product_id" class="form-label">Product</label>
              <select class="form-select" name="product_id" id="product_id">
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

        <div class="row">
          <div class="col-md-12 mb-3">
            <input type="hidden" name="total_price" value="0">
            <button type="submit" class="btn btn-primary"><i class="bi bi-credit-card-fill"></i> Pay</button>
          </div>
        </div>

      </form>

    </div>
</div>

<script>
  function calculateChange() {
      let totalPrice = parseFloat(document.getElementById('totalPrice').value.replace(/\./g, '').replace(',', '.'));
      let amountPaid = parseFloat(document.getElementById('amount_paid').value.replace(/\./g, '').replace(',', '.'));
      let change = amountPaid - totalPrice;

      document.getElementById('change').value = change;
  }

  document.getElementById('amount_paid').addEventListener('input', calculateChange);

  let totalPrice = 0;
  let quantity = 0;
  let items = [];

  function formatRupiah(angka, prefix) {
    var number_string = angka.toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

  function addItem() {
    let selectedProductId = $('#product_id').val();
    let selectedProduct = items.find(item => item.product_id == selectedProductId);

    if (selectedProduct) {
      let stock = parseInt($('#product_id').find(':selected').data('stock'));
      if (selectedProduct.quantity >= stock) {
          alert('Quantity cannot exceed available stock!');
          return;
      }
    }

    updateTotalPrice(parseInt($('#product_id').find(':selected').data('price')))
    let item = items.filter(el => el.product_id === $('#product_id').find(':selected').data('id'));
    let stock = parseInt($('#product_id').find(':selected').data('stock'));
    if (item.length > 0) {
      item[0].quantity += 1;
    } else {
        let item = {
          product_id: $('#product_id').find(':selected').data('id'),
          name: $('#product_id').find(':selected').data('name'),
          price: $('#product_id').find(':selected').data('price'),
          quantity: 1
        }
        items.push(item)
    }
    updateTotalQuantity(1)
    updateTable()
    calculateChange()
  }

  function deleteItem(index) {
      let item = items[index]
      items.splice(index, 1)
      updateTotalPrice(-(item.price * item.quantity))
      updateTotalQuantity(-(item.quantity))
      updateTable()
  }

  function updateTable() {
    let html = '';
    items.map((el, index) => {
        let price = formatRupiah(el.price.toString());
        let quantity = formatRupiah(el.quantity.toString());
        html += `
        <tr>
            <td>${index + 1}</td>
            <td>${el.name}</td>
            <td>
                <span id="quantity_${index}" class="editable-quantity" contenteditable="true" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  ${el.quantity}
                </span>
            </td>
            <td>${price}</td>
            <td>
                <input type="hidden" name="product_id[]" value="${el.product_id}">
                <input type="hidden" name="quantity[]" value="${el.quantity}">
                <button type="button" onclick="deleteItem(${index})" class="btn btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
        `;
    });
    $('.totalPrice').html(formatRupiah(totalPrice.toString()));
    $('.items').html(html);

    $('.editable-quantity').keydown(function(event) {
      let newValue = $(this).text().trim();
      let index = $(this).closest('tr').index();

      if (event.keyCode !== 13) {
          return;
      }

      if(newValue !== '') {
          updateQuantity(index, newValue);
      }
    });
  }

  function updateQuantity(index, newValue) {
    let item = items[index];
    let oldValue = item.quantity;
    let stock = parseInt($('#product_id').find(':selected').data('stock'));
    let diff = parseInt(newValue) - oldValue;

    if (parseInt(newValue) > stock) {
        newValue = stock;
        diff = newValue - oldValue;
    }

    items[index].quantity = parseInt(newValue);
    updateTotalQuantity(diff);
    updateTotalPrice(diff * item.price);
    updateTable();
    calculateChange();
  }

  function updateTotalPrice(nom) {
      totalPrice += nom;
      $('[name=total_price]').val(totalPrice)
      $('.totalPrice').html(formatRupiah(totalPrice.toString()))
  }

  function updateTotalQuantity(nom) {
      quantity += nom;
      $('.quantity').html(formatRupiah(quantity.toString()))
  }

  function emptyTable() {
    $('.items').html(`
    `)
  }

  $(document).ready(function() {
    emptyTable();
    updateTotalQuantity(0); 
  });

</script>

@endsection