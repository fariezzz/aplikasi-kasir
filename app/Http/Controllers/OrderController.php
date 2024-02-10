<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Faker\Factory as FakerFactory;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.order.index', [
            'title' => 'Item List',
            'orders' => Order::latest()->filter(request(['search', 'status']))->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.order.create', [
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
            'transaction_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        while (Order::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        }
        $validatedData['code'] = $uniqueCode;

        $transaction = Transaction::find($request['transaction_id']);
        $validatedData['customer_id'] = $transaction->customer_id;

        Order::create($validatedData);

        $transaction->update(['total_price' => $transaction->orders()->sum('total_price')]);

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
        Order::destroy($order->id);

        return back()->with('success', 'Order has been deleted.');
    }
}
