<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookHaven | {{ $title }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}" />
        <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="{{ asset('/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('/jquery/node_modules/jquery/dist/jquery.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('datatables/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
        <script src="{{ asset('datatables/node_modules/datatables.net/js/dataTables.min.js') }}"></script>
        <script src="{{ asset('datatables/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    </head>

    <body>
        @include('partials.sidebar')
        <div class="container">
            <main>
                @yield('container')
            </main> 
        </div>
            </div>

        <script src="{{ asset('/select2/dist/js/select2.min.js') }}"></script>
        <script>
            $(document).keydown(function(e) {
                if (e.altKey && e.key === 'T') {
                    window.location.href = '/transaction/checkout-now';
                }
            });

            $(document).keydown(function(e) {
                if (e.altKey && e.key === 'O') {
                    window.location.href = '/order/create';
                }
            });

            $('#logoutButton').click(function(e) {
                e.preventDefault();

                $('#logoutForm').submit();
            });

            let totalPrice = 0;
            let quantity = 0;
            let items = [];

            function formatRupiah(angka, prefix) {
                let number_string = angka.toString(),
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
                    quantity: 1,
                    stock: parseInt($('#product_id').find(':selected').data('stock')),
                    }
                    items.push(item)
                }
                updateTotalQuantity(1)
                updateTable()
                calculateChange()
            }

            function deleteItem(index) {
                let item = items[index];
                items.splice(index, 1);
                updateTotalPrice(-(item.price * item.quantity));
                updateTotalQuantity(-(item.quantity));
                updateTable();
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

                $('.editable-quantity').on('blur keypress', function(event) {
                    if (event.type === 'keypress' && event.key !== 'Enter') {
                        return;
                    }

                    if (event.type === 'blur' || event.key === 'Enter') {
                        let newValue = $(this).text().trim();
                        let index = $(this).closest('tr').index();

                        if (newValue !== '') {
                            updateQuantity(index, newValue);
                        }
                    }
                });
            }

            function updateQuantity(index, newValue) {
                let item = items[index];
                let oldValue = item.quantity;
                let stock = item.stock;
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
                $('[name=total_price]').val(totalPrice);
                $('.totalPrice').html(formatRupiah(totalPrice.toString()));
            }

            function updateTotalQuantity(nom) {
                quantity += nom;
                $('.quantity').html(formatRupiah(quantity.toString()));
            }

            function emptyTable() {
                $('.items').html(`
                `)
            }

            $(document).ready(function() {
                emptyTable();
                updateTotalQuantity(0);
            })

            function previewImage(){
                const image = document.querySelector('#image');
                const imgPreview = document.querySelector('.img-preview');

                imgPreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent){
                imgPreview.src = oFREvent.target.result;
                }
            }

            $(document).ready(function() {
                $('.deleteButton').on('click', function(event) {
                    const confirmDelete = confirm('Are you sure to delete the data?');
                    if (!confirmDelete) {
                        event.preventDefault();
                    }
                });
            });
            
            $(document).ready(function() {
                $('.cancelButton').on('click', function(event) {
                    const confirmDelete = confirm('Are you sure to cancel the order?');
                    if (!confirmDelete) {
                        event.preventDefault();
                    }
                });
            });

            $(document).ready(function() {
                $(".myForm").submit(function() {
                    $(".submitButton").prop("disabled", true);
                });
            });
        </script>

        <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>