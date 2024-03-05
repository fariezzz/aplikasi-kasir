<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Gate;
use Svg\Tag\Rect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product.index', [
            'title' => 'Items',
            'products' => Product::latest()->filter(request(['search', 'category']))->with(['supplier', 'category'])->paginate(6)->withQueryString(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('admin')) {
            return redirect('/product');
        }
        
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
        if (! Gate::allows('admin')) {
            return redirect('/product')->with('error', 'You do not have permission to perform this action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'description' => 'max:255|nullable',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0|max:99999999',
            'image' => 'image|file|max:1024'
        ], [
            'price.max' => 'The item price must be less than Rp. 100.000.000.'
        ]);

        $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        while (Product::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
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
        return redirect('/product');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        if (! Gate::allows('admin')) {
            return redirect('/product');
        }

        $decryptedCode = decrypt($code);
        $product = Product::where('code', $decryptedCode)->firstOrFail();

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
        if (! Gate::allows('admin')) {
            return redirect('/product')->with('error', 'You do not have permission to perform this action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'description' => 'max:255|nullable',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0|max:99999999',
            'image' => 'image|file|max:1024'
        ], [
            'price.max' => 'The item price must be less than Rp. 100.000.000.'
        ]);

        if($request->file('image')){
            if($product->image){
                Storage::delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('product-images');
        }

        Product::where('id', $product->id)->update($validatedData);

        return redirect('/product')->with('success', 'Item has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (! Gate::allows('admin')) {
            return redirect('/product')->with('error', 'You do not have permission to perform this action.');
        }

        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();
    
        return back()->with('success', 'Item and related orders/transactions have been deleted.');
    }

    public function updateStock(Request $request, $id) {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product->stock = $validatedData['stock'];
        $product->save();

        return back()->with('success', 'Stock has been updated.');
    }
}
