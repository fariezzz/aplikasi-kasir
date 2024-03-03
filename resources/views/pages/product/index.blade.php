@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Item List</h3>
    </div>

    @include('partials.alert')

    @include('partials.alertError')

    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                @can('admin')
                <a href="/product/create" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-circle"></i> Add Item
                </a>
                @endcan
            </div>
            <div class="col-lg-6">
                <form action="/product" method="GET" class="row g-3" id="productFilterForm">
                    <div class="col-lg-6">
                        <select class="form-select" name="category" id="selectCategory">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ Request::input('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" style="border-color:rgb(0, 0, 0);" placeholder="Search name..." name="search" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="my-2">
            {{ $products->links() }}
        </div>
        
        <div class="row" id="productList">
            @if($products->count())
                @foreach ($products as $product)
                    <div class="col-md-4 mb-3" data-category="{{ $product->category->slug }}">
                        <div class="card shadow-sm h-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top h-75" style="object-fit: cover;" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('storage/product-default.jpg') }}" class="card-img-top h-75" style="object-fit: cover;" alt="{{ $product->name }}">
                            @endif
                    
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <span class="card-text">Price: Rp. {{ number_format($product->price) }}</span><br>
                                <span class="card-text">Stock: {{ $product->stock }}</span>
                            </div>
                    
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary mx-2 btn-detail" data-code="{{ $product->code }}" data-name="{{ $product->name }}" data-category="{{ $product->category->name }}" data-supplier="{{ $product->supplier->name }}" data-description="{{ $product->description }}" data-stock="{{ $product->stock }}" data-price="{{ $product->price }}">
                                        <i class="bi bi-eye"></i>{{ auth()->user()->role == 'Admin' ? '' : ' Details' }}
                                    </button>
                    
                                    @can('admin')
                                    <a href="/product/{{ encrypt($product->code) }}/edit" class="btn btn-warning mx-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                    
                                    <form action="/product/{{ $product->code }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger mx-2 deleteButton">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div> 
                    </div>
                @endforeach
            @else
            <h3 class="text-center">No data.</h3>
            @endif
        </div>
    </div>
</div>
    
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Book Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <span id="detailName"></span></p>
                        <p><strong>Code:</strong> <span id="detailCode"></span></p>
                        <p><strong>Category:</strong> <span id="detailCategory"></span></p>
                        <p><strong>Supplier:</strong> <span id="detailSupplier"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Description:</strong> <span id="detailDescription"></span></p>
                        <p><strong>Stock:</strong> <span id="detailStock"></span></p>
                        <p><strong>Price:</strong> <span id="detailPrice"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  
<script>
    $(document).ready(function() {
        $('#category').change(function() {
            filterProducts();
        });

        $('#search').on('input', function() {
            filterProducts();
        });

        $('.btn-detail').click(function() {
            let name = $(this).data('name');
            let code = $(this).data('code');
            let category = $(this).data('category');
            let supplier = $(this).data('supplier');
            let description = $(this).data('description');
            let stock = $(this).data('stock');
            let price = $(this).data('price');

            $('#detailName').text(name);
            $('#detailCode').text(code);
            $('#detailCategory').text(category);
            $('#detailSupplier').text(supplier);
            $('#detailDescription').text(description);
            $('#detailStock').text(stock);
            $('#detailPrice').text(price);

            $('#detailsModal').modal('show');
        });

        $('#selectCategory').change(function() {
            $('#productFilterForm').submit();
        });

        // function filterProducts() {
        //     let category = $('#category').val().toLowerCase();
        //     let searchText = $('#search').val().toLowerCase();

        //     $('#productList .col-md-4').each(function() {
        //         let productCategory = $(this).data('category').toLowerCase();
        //         let productName = $(this).find('.card-title').text().toLowerCase();

        //         if ((category === '' || productCategory === category) && (searchText === '' || productName.includes(searchText))) {
        //             $(this).show(); 
        //         } else {
        //             $(this).hide();
        //         }
        //     });
        // }
    });
</script>

@endsection