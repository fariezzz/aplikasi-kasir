@extends('layouts.main')

@section('container')
<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3">
        <h3>Welcome, {{ auth()->user()->name }}</h3>
    </div>

  <div class="row">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people-fill"></i> Total Users</h5>
                <p class="card-text" style="font-size: 24px;">{{ $users->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-fill"></i> Total Products</h5>
                <p class="card-text" style="font-size: 24px;">{{ $products->count() }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-cash"></i> Income This Month</h5>
                <p class="card-text" style="font-size: 24px;">Rp. {{ number_format($incomeThisMonth) }}</p>
            </div>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
    </div>
  </div>
</div>

<script src="{{ asset('/chartjs/node_modules/chart.js/dist/chart.umd.js') }}"></script>
<script>
    (() => {
      'use strict'
    
      const ctx = document.getElementById('myChart')
      const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
          ],
          datasets: [{
            data: {!! json_encode($transactionCounts) !!},
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            y: {
                suggestedMin: 0,
                suggestedMax: Math.max(...{!! json_encode($transactionCounts) !!}) + 1,
                stepSize: 1,
                ticks: {
                    precision: 0
                }
            }
          },
          plugins: {
            title: {
                display: true,
                text: 'Daily Transaction Counts',
                font: {
                    size: 16
                }
            },
            legend: {
              display: false
            },
            tooltip: {
              boxPadding: 3
            }
          }
        }
      })
    })()
</script>    

@endsection
