<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.category.index', [
            'title' => 'Category List',
            'categories' => Category::with('products')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect('/category');

        // return view('pages.category.create', [
        //     'title' => 'Add Category'
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories'
        ]);

        Category::create($validatedData);

        return redirect('/category')->with('success', 'Category has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return redirect('/category');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return redirect('/category');
        
        // return view('pages.category.edit', [
        //     'title' => 'Edit Category',
        //     'category' => $category
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if($request->slug != $category->slug){
            $rules['slug'] = 'required|unique:categories';
        }

        $validatedData = $request->validate($rules);

        Category::where('id', $category->id)->update($validatedData);

        return back()->with('success', 'Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);

        return back()->with('success', 'Category has been deleted.');
    }
}
