@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Add Transaction</h3>
    </div>
    
    <div class="col-lg-12 container-fluid">
      <form class="row g-3" method="POST" action="/transaction">
        @csrf
        <div class="col-lg-6">
          <label for="user_id" class="form-label">Cashier</label>
            <select class="form-select" name="user_id" id="user_id">
              @foreach($users as $user)
                @if(old('user_id') == $user->id)
                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                @else
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
              @endforeach
            </select>
        </div>

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

        <div class="col-lg-6">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
</div>

@endsection