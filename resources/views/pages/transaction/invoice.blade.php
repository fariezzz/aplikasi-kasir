<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookHaven | Invoice</title>
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .printable {
            width: 90%;
        }
    </style>
</head>

<body>
    <div class="container">
        <main>
            <div class="mx-3 container-fluid printable" style="font-size: 15px">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom header">
                    <h3 class="fw-bold">INVOICE</h3>
                </div>

                <div class="d-flex justify-content-between mb-1">
                    <div class="d-flex flex-column align-items-start">
                        <span class="fw-bold">DATE:</span>
                        <span>{{ \Carbon\Carbon::parse($transaction->created_at)->format('l, F j Y') }}</span>
                    </div>   
                </div> 

                <div class="d-flex justify-content-between mb-1">
                    <div class="d-flex flex-column align-items-start">
                        <span class="fw-bold">TO:</span>
                        <span>{{ $transaction->customer->name }}</span>
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
                        @foreach(json_decode($transaction->product_id) as $key => $product_id)
                            <tr>
                                <td>{{ $products->where('id', $product_id)->first()->name }}</td>
                                <td>{{ json_decode($transaction->quantity)[$key] }}</td>
                                <td>Rp. {{ number_format($products->where('id', $product_id)->first()->price, 0, ',', ',') }}</td>
                                <td>Rp. {{ number_format(json_decode($transaction->quantity)[$key] * $products->where('id', $product_id)->first()->price, 0, ',', ',') }}</td>
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
                            <td><span class="fw-bold text-decoration-underline">Rp. {{ number_format($transaction->total_price, 0, ',', ',') }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </main> 
    </div>

    <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            print();     
        });

        window.onafterprint = function(event) {
            window.location.href = '/transaction';
        };
    </script>
</body>
</html>
