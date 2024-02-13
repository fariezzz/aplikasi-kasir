@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid printable">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Invoice</h3>
    </div>

    <div class="col">
        <a href="/transaction" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
        <a href="/transaction/invoice/{{ $transaction->code }}" class="btn btn-secondary mb-3"><i class="bi bi-printer"></i> Print</a>
    </div>

    <div class="d-flex justify-content-between mb-4">
        <div class="d-flex flex-column align-items-start">
            <span class="fw-bold">TO:</span>
            <span>{{ $transaction->customer->name }}</span>
        </div>   
    
        <div class="d-flex flex-column align-items-end">
            <span class="fw-bold">DATE:</span>
            <span>{{ \Carbon\Carbon::parse($transaction->created_at)->format('l, F j Y') }}</span>
        </div>   
    </div> 

    <div class="d-flex flex-column align-items-end mb-3">
        <span class="fw-bold">INVOICE CODE:</span>
        <span>{{ $transaction->code }}</span>
    </div>   

    <table class="table table-secondary mb-3" style="border-color:rgb(194, 194, 194);">
        <thead>
          <tr>
            <th scope="col">Product</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
            @foreach($transaction->orders as $order)
                <tr>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->quantity}}</td>
                    <td>Rp. {{ number_format($order->product->price, 0, ',', ',') }}</td>
                    <td>Rp. {{ number_format($order->quantity * $order->product->price, 0, ',', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>

    <div class="d-flex flex-column align-items-end">
        <table>
            <tr>
                <td><span>SUB TOTAL</span></td>
                <td><span class="mx-3">:</span></td>
                <td><span>Rp. {{ number_format($transaction->total_price, 0, ',', ',') }}</span></td>
            </tr>
            <tr>
                <td><span >TAX</span></td>
                <td><span class="mx-3">:</span></td>
                <td><span>Rp. 0</span></td>
            </tr>
            <tr>
                <td><span class="fw-bold">TOTAL</span></td>
                <td><span class="mx-3">:</span></td>
                <td><span>Rp. {{ number_format($transaction->total_price, 0, ',', ',') }}</span></td>
            </tr>
        </table>
    </div>
</div>
      
@endsection