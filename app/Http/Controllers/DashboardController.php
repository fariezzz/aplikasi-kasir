<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'users' => User::all(),
            'customers' => Customer::all(),
            'products' => Product::all(),
            'orders' => Order::all(),
            'transactions' => Transaction::all()
        ]);
    }
}
