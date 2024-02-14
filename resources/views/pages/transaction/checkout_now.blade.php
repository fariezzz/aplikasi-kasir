@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>{{ $title }}</h3>
    </div>
    
    <div class="col-lg-12 container-fluid">
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
                  <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{ $product->id }}">{{ $product->name }} (Rp. {{ number_format($product->price) }})</option>
                @endforeach
              </select>
          </div>
  
          <div class="col-lg-4">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-primary d-block mt-2" onclick="addItem()">Add Item</button>
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

        <div class="row">
          <div class="col-md-12 mb-3">
            <input type="hidden" name="total_price" value="0">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>

      </form>

    </div>
</div>

<script>
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
    updateTotalPrice(parseInt($('#product_id').find(':selected').data('price')))
    let item = items.filter(el => el.product_id === $('#product_id').find(':selected').data('id'));
    if (item.length > 0) {
        item[0].quantity += 1
    } else {
        let item = {
            product_id: $('#product_id').find(':selected').data('id'),
            name: $('#product_id').find(':selected').data('name'),
            price: $('#product_id').find(':selected').data('price'),
            quantity: 1
        }
        items.push(item)
    }
    updateQuantity(1)
    updateTable()
  }

  function deleteItem(index) {
      let item = items[index]
      if (item.quantity > 1) {
          items[index].quantity -= 1;
          updateTotalPrice(-(item.price))
          updateQuantity(-1)
      } else {
          items.splice(index, 1)
          updateTotalPrice(-(item.price * item.quantity))
          updateQuantity(-(item.quantity))
      }
      updateTable()
  }

  function updateTable() {
      let html = ''
      items.map((el, index) => {
          let price = formatRupiah(el.price.toString())
          let quantity = formatRupiah(el.quantity.toString())
          html += `
          <tr>
              <td>${index + 1}</td>
              <td>${el.name}</td>
              <td>${quantity}</td>
              <td>${price}</td>
              <td>
                  <input type="hidden" name="product_id[]" value="${el.product_id}">
                  <input type="hidden" name="quantity[]" value="${el.quantity}">
                  <button type="button" onclick="deleteItem(${index})" class="btn btn-danger"><i class="bi bi-trash"></i></button>
              </td>
          </tr>
          `
      })
      $('.totalPrice')
      $('.items').html(html)
  }

  function updateTotalPrice(nom) {
      totalPrice = totalPrice + nom;
      $('[name=total_price]').val(totalPrice)
      $('.totalPrice').html(formatRupiah(totalPrice.toString()))
  }

  function updateQuantity(nom) {
      quantity = quantity + nom;
      $('.quantity').html(formatRupiah(quantity.toString()))
  }

  function emptyTable() {
    $('.items').html(`
    `)
  }

  $(document).ready(function() {
      emptyTable()
  })

//   function calculateTotalPrice() {
//     let productId = document.getElementById('product_id').value;
//     let quantityInput = document.getElementById('quantity');
//     let quantity = quantityInput.value;

//     let product = @json($products->toArray());

//     let selectedProduct = product.find(function(prod) {
//         return prod.id == productId;
//     });

//     if (!selectedProduct) {
//         return;
//     }

//     quantityInput.setAttribute('max', selectedProduct.stock);

//     if (quantity > selectedProduct.stock) {
//         quantityInput.value = selectedProduct.stock;
//         quantity = selectedProduct.stock;
//     }

//     let totalPrice = selectedProduct.price * quantity;

//     document.getElementById('total_price').value = totalPrice;
// }

// document.getElementById('product_id').addEventListener('change', calculateTotalPrice);
// document.getElementById('quantity').addEventListener('input', calculateTotalPrice);

// calculateTotalPrice();

</script>

@endsection