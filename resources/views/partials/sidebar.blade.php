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
                <a href="/profile" class="sidebar-link">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#users" aria-expanded="false" aria-controls="users">
                    <i class="bi bi-person-vcard"></i>
                    <span>Users</span>
                </a>
                <ul id="users" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/users" class="sidebar-link">User List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/users/create" class="sidebar-link">Add User</a>
                    </li>
                </ul>
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
                    data-bs-target="#_category" aria-expanded="false" aria-controls="_category">
                    <i class="bi bi-tags-fill"></i>
                    <span>Categories</span>
                </a>
                <ul id="_category" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
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
                    data-bs-target="#suppliers" aria-expanded="false" aria-controls="suppliers">
                    <i class="bi bi-truck"></i>
                    <span>Suppliers</span>
                </a>
                <ul id="suppliers" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/category" class="sidebar-link">Supplier List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/category/create" class="sidebar-link">Add Supplier</a>
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
                <a href="/transaction" class="sidebar-link">
                    <i class="bi bi-credit-card"></i>
                    <span>Transaction</span>
                </a>
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