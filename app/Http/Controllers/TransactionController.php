<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Faker\Factory as FakerFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::query();
        if ($request->has('sort')) {
            if ($request->sort == 'asc') {
                $transactions->orderBy('date', 'asc');
            } elseif ($request->sort == 'desc') {
                $transactions->orderBy('date', 'desc');
            }
        }
        else {
            $transactions->orderBy('date', 'asc');
        }

        return view('pages.transaction.index', [
            'title' => 'Transaction List',
            'transactions' => $transactions->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $selectedOrders = session('selected_orders', collect());
        $unselectedOrders = Order::all()->diff($selectedOrders);
        return view('pages.transaction.create', [
            'title' => 'Add Transaction',
            'users' => User::all(),
            'customers' => Customer::all(),
            'orders' => Order::all(),
            'selectedOrders' => $selectedOrders,
            'unselectedOrders' => $unselectedOrders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $selectedOrders = session('selected_orders', collect());

        if ($selectedOrders->isEmpty()) {
            return back()->with('error', 'Please select at least one order.');
        }

        if ($selectedOrders->pluck('customer_id')->unique()->count() !== 1) {
            return back()->with('error', 'Please ensure that all selected orders have the same customer.');
        }

        $transaction = new Transaction();
        $transaction->user_id = auth()->user()->id;
        $transaction->customer_id = $selectedOrders->first()->customer_id;

        $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        while (Transaction::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        }
        $transaction->code = $uniqueCode;

        $transaction->date = now();
        $transaction->total_price = $selectedOrders->sum('total_price');

        $transaction->save();

        foreach ($selectedOrders as $order) {
            $order->transaction_id = $transaction->id;
            $order->status = 'Done';
            $order->save();
        }

        $request->session()->forget('selected_orders');

        return redirect('/transaction')->with('success', 'Data has been added. Print <a href="' . route('invoice.print', $transaction->code) . '">here</a>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('pages.transaction.show', [
            'title' => 'Invoice',
            'transaction' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        Transaction::destroy($transaction->id);

        return back()->with('success', 'Data has been deleted');
    }

    public function addToSelectedOrder(Request $request, Order $order){
        if (!$request->session()->has('selected_orders')) {
            $request->session()->put('selected_orders', collect());
        }

        $selectedOrders = $request->session()->get('selected_orders');
        $selectedOrders->push($order);
        $request->session()->put('selected_orders', $selectedOrders);

        return back();
    }

    public function removeFromSelectedOrder(Request $request, Order $order){
        if ($request->session()->has('selected_orders')) {
            $selectedOrders = $request->session()->get('selected_orders');

            $selectedOrders = $selectedOrders->reject(function ($item) use ($order) {
                return $item->id === $order->id;
            });

            $request->session()->put('selected_orders', $selectedOrders);
        }

        return back();
    }

    public function template($code){
        $transaction = Transaction::where('code', $code)->first();
        // $title = 'Invoice';

        // if(request('output') == 'pdf') {
        //     $pdf = Pdf::loadView('pages.transaction.invoice', compact('title', 'transaction'));
        //     return $pdf->download('invoice.pdf');
        // }

        return view('pages.transaction.invoice', [
            'title' => 'Invoice',
            'transaction' => $transaction
        ]);
    }
}
