<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
//        $orders = $user->orders()
//            ->with(['cart.items.product.images'])
//            ->get();
        $orders = $user->orders()->get();
        return view('orders.index',compact(['orders']));
    }

    public function all()
    {
        $orders = Order::paginate(64);
        return view('admin.orders.index',compact('orders'));
    }

    public function showAdmin($id)
    {
        $order = Order::with(['user.carts.items.product.images'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function changeStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if(!$order){
            return redirect()->back()->with('error','could not find order');
        }
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('success','order status has been updated');
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

        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart) {
            return redirect()->back()->with('error' , 'Active cart not found');
        }

        $cartItem = $cart->items()->where('cart_id', $cart->id)->first();

        if(!$cartItem){
            return redirect()->back()->with('error','Cart is empty');
        }


        $totalPrice = $cart->items->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->quantity);
        }, 0);


        try {
            Order::create([
                'user_id' => $user->id,
                'cart_id' => $cart->id,
                'address' => $validatedData['address'],
                'contact_phone' => $validatedData['contact_phone'] ?? $user->phone,
                'total_price' => $totalPrice,
                'status' => 'new'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error' , 'An error occurred while creating the order');
        }

        $cart->status = 'finished';
        $cart->save();

        return redirect()->back()->with('success', 'Order created successfully');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['cart.items.product.images'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if(!$order){
            return redirect()->back()->with('error', 'Order cpild not find');
        }
        $order->delete();
        return redirect()->back()->with('success', 'Order removed successfully');
    }
}
