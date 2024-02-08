@extends('layouts.main')

@section('container')
<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3">
        <h3>Welcome, {{ auth()->user()->name }}</h3>
    </div>

  <div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Box 1</h5>
                <p class="card-text">Isi konten box pertama di sini.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Box 2</h5>
                <p class="card-text">Isi konten box kedua di sini.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Box 3</h5>
                <p class="card-text">Isi konten box ketiga di sini.</p>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection