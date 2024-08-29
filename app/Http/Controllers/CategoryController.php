<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.home', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $category = Category::create($request->all());

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function remove($itemId)
    {
        $category = Category::find($itemId);
        if ($category) {
            $category->delete();
            return redirect()->back()->with('success', 'Category deleted successfully');
        }

        return redirect()->back()->with('error', 'Category not found');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::where('category_id',$id)->paginate(10);
        return view('products.show',compact('products'));
    }

    public function listForAdmin()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
