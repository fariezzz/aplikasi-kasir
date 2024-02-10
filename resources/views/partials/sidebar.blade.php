<div class="wrapper d-flex flex-column">
    <aside id="sidebar">
        <div class="d-flex container-fluid mt-3">
            <div class="sidebar-logo mx-3">
                <a href="/"><img src="{{ asset('logo/bookhaven-logo.png') }}" width="50" height="auto" alt=""></a>
            </div>
            <div class="sidebar-logo-text mt-3">
                <a href="/">BookHaven</a>
            </div>
        </div>
        <ul class="sidebar-nav py-3">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#products" aria-expanded="false" aria-controls="products">
                    <i class="bi bi-box-fill"></i>
                    <span>Products</span>
                </a>
                <ul id="products" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/product" class="sidebar-link">Item List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/product/create" class="sidebar-link">Add Item</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#category" aria-expanded="false" aria-controls="category">
                    <i class="bi bi-tags-fill"></i>
                    <span>Categories</span>
                </a>
                <ul id="category" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/category" class="sidebar-link">Category List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/category/create" class="sidebar-link">Add Category</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#customers" aria-expanded="false" aria-controls="customers">
                    <i class="bi bi-people-fill"></i>
                    <span>Customers</span>
                </a>
                <ul id="customers" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/customer" class="sidebar-link">Customer List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/customer/create" class="sidebar-link">Add Customer</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#orders" aria-expanded="false" aria-controls="orders">
                    <i class="bi bi-receipt"></i>
                    <span>Orders</span>
                </a>
                <ul id="orders" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/order" class="sidebar-link">Order List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/order/create" class="sidebar-link">Add Order</a>
                    </li>
                </ul>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#transaction" aria-expanded="false" aria-controls="transaction">
                    <i class="bi bi-credit-card"></i>
                    <span>Transaction</span>
                </a>
                <ul id="transaction" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/transaction" class="sidebar-link">Transaction List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/transaction/create" class="sidebar-link">Add Data</a>
                    </li>
                </ul>
            </li>

        </ul>
        <div class="sidebar-footer">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="sidebar-link btn btn-link text-decoration-none text-white mx-2 mb-4">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="logout-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>
{{-- </div> --}}