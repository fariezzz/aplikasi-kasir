<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.order.index', [
            'title' => 'Item List',
            'orders' => Order::latest()->filter(request(['search', 'status']))->with(['transaction', 'customer'])->get(),
            'products' => Product::all()    
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
            'transactions' => Transaction::all(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (empty($request->product_id)) {
            return back()->with('error', 'Product ID cannot be empty. Pick at least one item.');
        }
    
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $validatedData['product_id'] = json_encode($request->product_id);
        $validatedData['quantity'] = json_encode($request->quantity);
    
        $validatedData['customer_id'] = $request->customer_id;
        $validatedData['total_price'] = $request->total_price;
        $validatedData['status'] = 'Pending';

        $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        while (Order::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        }
        $validatedData['code'] = $uniqueCode;

        Order::create($validatedData);

        foreach ($request->product_id as $index => $product_id) {
            $product = Product::find($product_id);
            $product->stock -= $request->quantity[$index];
            $product->save();
        }
    
        return redirect('/order')->with('success', 'Order has been added. Pay <a href="/transaction/create" class="text-decoration-underline">here.</a>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return redirect('/order');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return redirect('/order');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        foreach (json_decode($order->product_id) as $index => $product_id) {
            $product = Product::find($product_id);
            $product->stock += json_decode($order->quantity)[$index];
            $product->save();
        }

        $order->update(['status' => 'Cancelled']);

        $request->session()->forget('selected_orders');

        return back()->with('success', 'Order has been cancelled.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Order $order)
    {
        if (! Gate::allows('admin')) {
            return redirect('/order')->with('error', 'You do not have permission to perform this action.');
        }

        $order->transaction()->delete();

        $request->session()->forget('selected_orders');

        Order::destroy($order->id);

        return back()->with('success', 'Order has been deleted.');
    }
}
