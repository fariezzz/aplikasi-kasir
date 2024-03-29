<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.transaction.index', [
            'title' => 'Transaction List',
            'products' => Product::all(),
            'transactions' => Transaction::latest()->with(['user', 'customer'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function payOrder($code)
    {
        $decryptedCode = decrypt($code);
        $order = Order::where('code', $decryptedCode)->firstOrFail();

        return view('pages.transaction.create', [
            'title' => 'Pay Order',
            'order' => $order,
            'customers' => Customer::all(),
            'products' => Product::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Order $order, Request $request)
    {
        if($request->amount_paid < $request->total_price){
            return back()->with('error', 'Insufficient funds.');
        }
        
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'total_price' => 'required|numeric|min:0|max:99999999',
        ], [
            'total_price.max' => 'The total price must be less than Rp. 100.000.000.'
        ]);

        $validatedData['product_id'] = json_encode($request->product_id);
        $validatedData['quantity'] = json_encode($request->quantity);
    
        $validatedData['user_id'] = auth()->user()->id; 
        $validatedData['date'] = now();

        $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        while (Transaction::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        }
        $validatedData['code'] = $uniqueCode;

        $transaction = Transaction::create($validatedData);

        $order->transaction_id = $transaction->id;
        $order->status = 'Done';
        $order->save();
    
        return redirect('/order')->with('success', 'Transaction has been saved. Print <a href="' . route('invoice.print', encrypt($validatedData['code'])) . '" class="text-decoration-underline">here.</a>');
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $decryptedCode = decrypt($code);
        $transaction = Transaction::where('code', $decryptedCode)->firstOrFail();

        return view('pages.transaction.show', [
            'title' => 'Invoice',
            'transaction' => $transaction,
            'products' => Product::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Transaction $transaction)
    {
        $productIds = json_decode($transaction->product_id);
        $quantities = json_decode($transaction->quantity);

        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);
            $quantity = $quantities[$index];
            
            $product->stock += $quantity;

            $product->save();
        }

        $transaction->delete();

        return back()->with('success', 'The transaction has been successfully canceled and the stock has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        return back();

        if (! Gate::allows('admin')) {
            return redirect('/transaction')->with('error', 'You do not have permission to perform this action.');
        }

        Transaction::destroy($transaction->id);

        return back()->with('success', 'Data has been deleted');
    }

    public function template($code){
        $decryptedCode = decrypt($code);
        $transaction = Transaction::where('code', $decryptedCode)->firstOrFail();

        return view('pages.transaction.invoice', [
            'title' => 'Invoice',
            'transaction' => $transaction,
            'products' => Product::all(),
        ]);
    }

    public function checkoutNow(){
        return view('pages.transaction.checkout_now', [
            'title' => 'Checkout Now',
            'customers' => Customer::all(),
            'products' => Product::all(),
        ]);
    }

    public function payNow(Request $request){
        if (empty($request->product_id)) {
            return back()->with('error', 'Product ID cannot be empty. Pick at least one item.');
        }

        if($request->amount_paid < $request->total_price){
            return back()->with('error', 'Insufficient funds.');
        }

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'total_price' => 'required|numeric|min:0|max:99999999',
        ], [
            'total_price.max' => 'The total price must be less than Rp. 100.000.000.'
        ]);

        $validatedData['product_id'] = json_encode($validatedData['product_id']);
        $validatedData['quantity'] = json_encode($validatedData['quantity']);
    
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['date'] = now();

        $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        while (Transaction::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        }
        $validatedData['code'] = $uniqueCode;

        Transaction::create($validatedData);

        foreach ($request->product_id as $index => $product_id) {
            $product = Product::find($product_id);
            $product->stock -= $request->quantity[$index];
            $product->save();
        }
    
        return redirect('/transaction')->with('success', 'Transaction has been saved. Print <a href="' . route('invoice.print', encrypt($validatedData['code'])) . '" class="text-decoration-underline">here.</a>');
    }
}
