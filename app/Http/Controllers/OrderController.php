<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.order.index', [
            'title' => 'Item List',
            'orders' => Order::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.order.add', [
            'title' => 'Add Order',
            'users' => User::all(),
            'products' => Product::all(),
            'transactions' => Transaction::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:orders',
            'transaction_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $transaction = Transaction::find($request['transaction_id']);
        $validatedData['user_id'] = $transaction->user_id;

        Order::create($validatedData);

        return redirect('/order')->with('success', 'Order has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
