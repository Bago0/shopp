<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $cart = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if (!$cart) {
                return response()->json(['error' => 'Cart not found'], 404);
            }

            $cartItems = $cart->items()
                ->with(['product.images'])
                ->get();

            return response()->json($cartItems);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching cart items', 'details' => $e->getMessage()], 500);
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        $user = Auth::user();
        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found'], 404);
        }

        $cartItem = $cart->items()->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $quantity = $request->input('quantity');

        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity'], 400);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json(['success' => true]);
    }


    public function removeCartItem(Request $request, $id)
    {
        $user = Auth::user();
        $cart = $user->carts()->where('status', 'active')->first();
        if (!$cart) {
            return redirect()->back()->with('success','Cart not found');
        }
        $cartItem = $cart->items()->where('id', $id)->first();
        if (!$cartItem) {
            return redirect()->back()->with('success','Cart item not found');
        }
        $cartItem->delete();

//        $cartItem = $cart->items()->where('id', $id)->first();
//        if (!$cartItem) {
//            $cart->delete();
//        }

        return redirect()->back()->with('success','Cart item removed');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
