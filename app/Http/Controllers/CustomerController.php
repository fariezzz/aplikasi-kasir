<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.customer.index', [
            'title' => 'Customer List',
            'customers' => Customer::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect('/customer');

        // return view('pages.customer.create', [
        //     'title' => 'Add Customer',
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required'
        ]);

        Customer::create($validatedData);

        return redirect('/customer')->with('success', 'Customer has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return redirect('/customer');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return redirect('/customer');

        // return view('pages.customer.edit', [
        //     'title' => 'Edit Customer',
        //     'customer' => $customer
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required'
        ]);

        Customer::where('id', $customer->id)->update($validatedData);

        return redirect('/customer')->with('success', 'Customer has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if (! Gate::allows('admin')) {
            return redirect('/customer')->with('error', 'You do not have permission to perform this action.');
        }

        Customer::destroy($customer->id);

        return back()->with('success', 'Customer has been deleted.');
    }
}
