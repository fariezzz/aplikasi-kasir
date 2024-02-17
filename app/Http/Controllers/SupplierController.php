<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.supplier.index', [
            'title' => 'Supplier List',
            'suppliers' => Supplier::paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('.pages.supplier.create', [
            'title' => 'Add Supplier'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:suppliers',
            'contact' => 'required',
            'address' => 'required|max:255',
            'description' => 'nullable|max:255',
        ]);

        Supplier::create($validatedData);

        return redirect('/suppliers')->with('success' ,'New supplier has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('pages.supplier.edit', [
            'title' => 'Edit Supplier',
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'name' => 'required|max:255',
            'contact' => 'required',
            'address' => 'required|max:255',
            'description' => 'nullable|max:255',
        ];

        if($request->email != $supplier->email){
            $rules['email'] = 'required|email:dns|unique:suppliers';
        }

        $validatedData = $request->validate($rules);

        Supplier::where('id', $supplier->id)->update($validatedData);

        return redirect('/suppliers')->with('success' ,'Supplier has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $products = $supplier->products()->get();

        foreach ($products as $product) {
            $product->delete();
        }

        $supplier->delete();

        return back()->with('success', 'Supplier has been deleted.');
    }
}
