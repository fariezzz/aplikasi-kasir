<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product.index', [
            'title' => 'Items',
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product.add', [
            'title' => 'Add Item',
            'categories' => Category::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'code' => 'required|max:6|unique:products',
            'description' => 'max:255|nullable',
            'stock' => 'integer|min:1',
            'price' => 'required',
            'image' => 'image|file|max:1024'
        ]);

        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('product-images');
        }

        Product::create($validatedData);

        return redirect('/product')->with('success', 'Item added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('pages.product.edit', [
            'title' => 'Edit Item',
            'product' => $product,
            'categories' => Category::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'code' => 'required|max:6|unique:products',
            'description' => 'max:255|nullable',
            'stock' => 'integer|min:1',
            'price' => 'required',
            'image' => 'image|file|max:1024'
        ]);

        if($request->code != $product->code){
            $validatedData['code'] = 'required|max:6|unique:products';
        }

        if($request->file('image')){
            if($product->image){
                Storage::delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        Product::where('id', $product->id)->update($validatedData);

        return redirect('/product')->with('success', 'Item has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->image){
            Storage::delete($product->image);
        }

        Product::destroy($product->id);

        return back()->with('success', 'Item has been deleted.');
    }
}
