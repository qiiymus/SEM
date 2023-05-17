<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check whether user login or not, if not redirect to login
        if (!auth()->user()) {
            // Redirect to login page
            return redirect()->route('login');
        }

        $carts = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->join('users', 'users.id', '=', 'carts.user_id')
            ->select('carts.id', 'carts.product_id', 'products.product_name', 'products.product_price', 'carts.quantity', 'carts.updated_at')
            ->orderBy('carts.updated_at', 'desc')
            ->get();

        $carts->each(function ($cart) {
            $cart->total = $cart->product_price * $cart->quantity;
        });

        $totalPrice = $carts->sum('total');


        // dd($carts);

        return view('payment.cart', compact('carts', 'totalPrice'));
    }

    /**
     * Store a newly created resource in Cart.
     */
    public function storeCart(Request $request)
    {
        $cart = new Cart();
        $cart->user_id = auth()->user()->id;

        try {
            $item = Product::findOrFail($request->product_id)->id;
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cart')->with('error', 'Product barcode not exist!');
        }
        $cart->product_id = $request->product_id;

        if ($request->quantity == null) {
            $cart->quantity = 1;
        } else {
            $cart->quantity = $request->quantity;
        }

        if ($cart->save()) {
            return redirect()->route('cart')->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->route('cart')->with('error', 'Failed to add product to cart!');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function incrementQuantity($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart->quantity++;

        if ($cart->save()) {
            return redirect()->back()->with('success', 'Quantity updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update quantity.');
        }
    }

    public function decrementQuantity($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($cart->quantity == 1) {
            PaymentController::destroyCart($id);
            return redirect()->back()->with('success', 'Product deleted from cart!');
        } else {
            $cart->quantity--;
        }

        if ($cart->save()) {
            return redirect()->back()->with('success', 'Quantity updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update quantity.');
        }
    }


    /**
     * Remove the specified resource from Cart.
     */
    public function destroyCart($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Cannot delete product!');
        }

        if ($cart->delete()) {
            return redirect()->route('cart')->with('success', 'Product deleted from cart successfully!');
        } else {
            return redirect()->route('cart')->with('error', 'Failed to delete product from cart!');
        }
    }
}
