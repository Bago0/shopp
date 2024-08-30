<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)->with('images')->orderBy('created_at', 'desc')->take(6)->get();;

        $categorizedProducts = Category::with('products.images')->orderBy('created_at', 'desc')->take(6)->get();

        $categories = Category::all();

        $uncategorizedProducts = Product::whereNull('category_id')->with('images')->orderBy('created_at', 'desc')->take(6)->get();

        return view('index', compact('featuredProducts', 'categorizedProducts','categories', 'uncategorizedProducts'));
    }
}
