<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Faker\Factory as FakerFactory;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.transaction.index', [
            'title' => 'Transaction List',
            'transactions' => Transaction::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.transaction.create', [
            'title' => 'Add Transaction',
            'users' => User::all(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'user_id' => 'required',
            'date' => 'required|date',
        ]);

        $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        while (Transaction::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        }
        $validatedData['code'] = $uniqueCode;

        $validatedData['total_price'] = 0;
        
        Transaction::create($validatedData);

        return redirect('/transaction')->with('success', 'Data has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
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
        //
    }
}
