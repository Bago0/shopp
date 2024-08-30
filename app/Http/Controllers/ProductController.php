<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['images', 'category'])->paginate(24);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->input('is_featured') == 'on' ? $is_featured = true : $is_featured = false;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'required|integer|min:0'
        ]);
        $validated['price'] = intval($validated['price'] * 100);
        $newImageCount = $request->file('images') ? count($request->file('images')) : 0;
        $validated['is_featured'] = $is_featured;

        if ($newImageCount > 4) {
            return redirect()->back()->with('error' , 'Each product can have a maximum of 4 images.');
        }

        $product = Product::create($validated);

        $mainImageIndex = $request->input('main_image');
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $index => $image) {
                $path = $image->store('images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => ($index == $mainImageIndex),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('products.index', compact('product', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'nullable|integer'
        ]);

        $currentImageCount = $product->images()->count();

        $newImageCount = $request->file('images') ? count($request->file('images')) : 0;

        if ($currentImageCount + $newImageCount > 4) {
            return redirect()->back()->with('error' , 'Each product can have a maximum of 4 images.');
        }
        $validated['price'] = intval($validated['price'] * 100);
        $product->update($validated);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();

        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active']
        );

        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' =>  $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            Storage::delete('public/' . $image->image_path);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
