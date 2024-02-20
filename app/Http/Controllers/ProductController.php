<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as FakerFactory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product.index', [
            'title' => 'Items',
            'products' => Product::latest()->get(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product.create', [
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
            'description' => 'max:255|nullable',
            'stock' => 'integer|min:0',
            'price' => 'required',
            'image' => 'image|file|max:1024'
        ]);

        $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        while (Product::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('#-##');
        }
        $validatedData['code'] = $uniqueCode;

        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('product-images');
        }

        Product::create($validatedData);

        return redirect('/product')->with('success', 'Item has been added.');
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
            'description' => 'max:255|nullable',
            'stock' => 'integer|min:0',
            'price' => 'required',
            'image' => 'image|file|max:1024'
        ]);

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
        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();
    
        return back()->with('success', 'Item and related orders/transactions have been deleted.');
    }
}
