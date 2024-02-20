@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Order List</h3>
  </div>

  @include('partials.alert')

  <div class="row justify-content-between mb-2">
    <div class="col-lg-7">
      <a href="/order/create" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add Order</a>
    </div>
    <div class="col-lg-4">
      <form action="/order" method="GET" class="row">
          <div class="col-lg-12">
              <div>
                  <select class="form-select" name="status" id="status">
                      <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Statuses</option>
                      <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                      <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                      <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                  </select>
              </div>
          </div>
      </form>
    </div>
  </div>

  @if($orders->count())
  <table class="table table-bordered align-middle" id="order-table" style="border-color:rgb(194, 194, 194);">
      <thead>
        <tr>
          <th scope="col" class="table-primary align-middle">#</th>
          <th scope="col" class="table-primary align-middle">Code</th>
          <th scope="col" class="table-primary align-middle">Customer</th>
          <th scope="col" class="table-primary align-middle">Product (qty)</th>
          <th scope="col" class="table-primary align-middle">Total</th>
          <th scope="col" class="table-primary align-middle">Status</th>
          <th scope="col" class="table-primary align-middle text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach($orders as $order)
            <tr>
                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                <td class="text-center">{{ $order->code }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>
                  @foreach(json_decode($order->product_id) as $key => $product_id)
                    {{ $products->where('id', $product_id)->first()->name }}({{ json_decode($order->quantity)[$key] }})
                    @if(!$loop->last)
                        ,
                    @endif
                  @endforeach
                </td>
                <td data-order="{{ $order->total_price }}">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $order->status }}</td>
                <td scope="col">
                  <div class="d-flex justify-content-center">
                    @if($order->status == 'Done' || $order->status == 'Cancelled')
                      @if(auth()->user()->role == 'Admin')
                        <form action="/order/{{ $order->id }}" method="POST">
                          @method('delete')
                          @csrf
                          <button class="btn btn-danger mx-2 deleteButton">
                            <i class="bi bi-trash3"></i>
                          </button>
                        </form>
                      @else
                        <span>-</span>
                      @endif
                    @else
                    <a href="/transaction/pay-order/{{ $order->code }}" class="btn btn-primary">
                      <i class="bi bi-credit-card-fill"></i>
                    </a>
                    <form action="/order/{{ $order->id }}" method="POST">
                      @method('put')
                      @csrf
                      <button class="btn btn-danger mx-2 cancelButton">
                        <i class="bi bi-x-circle"></i>
                      </button>
                    </form>
                    @endif
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
    $('#order-table').DataTable({
      "columnDefs": [
        { "type": "num", "targets": 4 },
        { "orderable": false, "targets": 6 }
      ]
    });

    $('#status').change(function() {
      let status = $(this).val();
      window.location.href = `/order?status=${status}`;
    });
  });
</script>

@endsection