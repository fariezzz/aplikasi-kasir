@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Transaction</h3>
    </div>

    @include('partials.alert')

    <div class="row justify-content-end mb-4">
      
      <div class="d-flex ">
        <div class="col-md-5 d-flex justify-content-start">
          <div class="m-0 d-flex justify-content-end" style="margin-left: 1rem">
            <a href="/transaction?sort=asc" class="btn btn-secondary me-2 sort-button">Sort by Date (Asc)</a>
            <a href="/transaction?sort=desc" class="btn btn-secondary sort-button">Sort by Date (Desc)</a>
          </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end">
          <form action="/transaction" method="GET" class="d-flex justify-content-end"> 
              <div class="col-md-8 me-2">
                  <div class="input-group">
                      <input type="text" class="form-control" style="border-color:rgb(0, 0, 0); width:350px" placeholder="Search customer..." name="search" value="{{ request('search') }}">
                  </div>
              </div>
  
              <div class="col-md-2 d-flex justify-content-between align-self-center">
                  <button class="btn btn-primary" type="submit">Search</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col mb-3">
      <a href="/transaction/create" class="btn btn-primary">
        <i class="bi bi-cart4"></i> Pay Orders
      </a>
      <a href="/transaction/checkout-now" class="btn btn-primary ms-2">
        <i class="bi bi-cart-check"></i> Checkout Now
      </a>
    </div>

    @if($transactions->count())
    <table class="table table-bordered text-center" style="border-color:rgb(194, 194, 194);">
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
            @foreach($transactions as $transaction)
              <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $transaction->code }}</td>
                  <td>{{ $transaction->customer->name }}</td>
                  <td>
                    @php
                        $groupedOrders = $transaction->orders->groupBy('product_id');
                    @endphp
                    
                    @foreach($groupedOrders as $productId => $orders)
                        @php
                            $productName = $orders->first()->product->name;
                            $totalQuantity = $orders->sum('quantity');
                        @endphp
                        
                        {{ $productName }} ({{ $totalQuantity }})
                        
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                  </td>
                  <td>Rp. {{ number_format($transaction->orders->sum('total_price'), 0, ',', '.') }}</td>
                  <td>{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
                  <td scope="col" class="d-flex justify-content-center">
                    <a href="/transaction/{{ $transaction->code }}" class="btn btn-primary mx-2" ><i class="bi bi-eye-fill"></i></a>
                    <form action="/transaction/{{ $transaction->code }}" method="POST">
                      @method('delete')
                      @csrf
                      <button class="btn btn-danger mx-2" onclick="return confirm('Are you sure to delete the transaction?')"><i class="bi bi-trash3"></i></button>
                    </form>
                  </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      @else
      <h3 class="text-center">No data.</h3>
      @endif
      {{ $transactions->appends(request()->input())->links() }}

@endsection