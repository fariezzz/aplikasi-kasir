<div class="wrapper d-flex flex-column">
    <aside id="sidebar">
        <div class="d-flex container-fluid mt-3 sidebar-header">
            <div class="sidebar-logo mx-3">
                <a href="/"><img src="{{ asset('logo/bookhaven-logo.png') }}" width="50" height="auto" alt=""></a>
            </div>
            <div class="sidebar-logo-text mt-3">
                <a href="/">BookHaven</a>
            </div>
        </div>
        <ul class="sidebar-nav py-3">
            <li class="sidebar-item">
                <a href="/" class="sidebar-link {{ Request::is('/') ? 'link-active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/profile" class="sidebar-link {{ Request::is('profile*') ? 'link-active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile</span>
                </a>
            </li>

            @can('admin')
            <li class="sidebar-item">
                <a href="/users" class="sidebar-link {{ Request::is('users*') ? 'link-active' : '' }}">
                    <i class="bi bi-person-vcard"></i>
                    <span>Users</span>
                </a>
            </li>
            @endcan

            @can('admin')
            <li class="sidebar-item">
                <a href="/account-requests" class="sidebar-link {{ Request::is('account-requests*') ? 'link-active' : '' }}">
                    <i class="bi bi-envelope-fill"></i>
                    <span>Account Requests</span>
                    @if(Illuminate\Support\Facades\Cache::has('new_request'))
                        <span class="dot"></span>
                    @endif
                </a>
            </li>
            @endcan

            <li class="sidebar-item">
                <a href="/product" class="sidebar-link {{ Request::is('product*') ? 'link-active' : '' }}">
                    <i class="bi bi-box-fill"></i>
                    <span>Products</span>
                </a>
            </li>
            
            @can('admin')
            <li class="sidebar-item">
                <a href="/category" class="sidebar-link {{ Request::is('category*') ? 'link-active' : '' }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Categories</span>
                </a>
            </li>
            @endcan

            @can('admin')
            <li class="sidebar-item">
                <a href="/suppliers" class="sidebar-link {{ Request::is('suppliers*') ? 'link-active' : '' }}">
                    <i class="bi bi-truck"></i>
                    <span>Suppliers</span>
                </a>
            </li>
            @endcan

            <li class="sidebar-item">
                <a href="/customer" class="sidebar-link {{ Request::is('customer*') ? 'link-active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Customers</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/order" class="sidebar-link {{ Request::is('order*') ? 'link-active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/transaction" class="sidebar-link {{ Request::is('transaction*') ? 'link-active' : '' }}">
                    <i class="bi bi-credit-card"></i>
                    <span>Transaction</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="#" id="logoutButton" class="sidebar-link mb-3">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
            <form id="logoutForm" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
            {{-- <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="sidebar-link btn btn-link text-decoration-none text-white mx-2 mb-4">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="logout-text">Logout</span>
                </button>
            </form> --}}
        </div>
    </aside>
{{-- </div> --}}