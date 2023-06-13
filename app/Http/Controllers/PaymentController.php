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
            ->select('carts.id', 'products.product_id', 'products.product_name', 'products.product_price', 'carts.quantity', 'carts.created_at', 'carts.payment_id')
            ->where('carts.payment_id', '=', null)
            ->where('carts.user_id', '=', auth()->user()->id)
            ->orderBy('carts.created_at', 'desc')
            ->get();

        $carts->each(function ($cart) {
            $cart->total = $cart->product_price * $cart->quantity;
        });

        $totalPrice = $carts->sum('total');


        // dd($carts);

        return view('payment.cart', compact('carts', 'totalPrice'));
    }

    public function paymentIndex()
    {
        $carts = Cart::where('user_id', '=', auth()->user()->id)
            ->where('payment_id', '=', null)
            ->get();

        // If cart is empty, redirect to cart page
        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Cart is empty!');
        }

        $carts->each(function ($cart) {
            $cart->total = $cart->product->product_price * $cart->quantity;
        });

        $totalPrice = $carts->sum('total');

        // dd($carts, $totalPrice);

        return view('payment.payment', compact('totalPrice'));
    }

    public function changeIndex(Payment $payment)
    {
        try {
            $payment = Payment::findOrFail($payment->id);
        } catch (ModelNotFoundException) {
            return redirect()->route('cart')->with('error', 'Payment not found!');
        }

        $payment = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->join('payments', 'payments.id', '=', 'carts.payment_id')
            ->select('products.product_id', 'products.product_name', 'products.product_price', 'carts.quantity', 'payments.id', 'carts.created_at', "payments.total_price", "payments.payment_method", "payments.cash_amount")
            ->where('carts.payment_id', '=', $payment->id)
            ->orderBy('carts.created_at', 'desc')
            ->get();

        $totalPrice = $payment->last()->total_price;
        $cashAmount = $payment->last()->cash_amount;
        $totalChange = $cashAmount - $totalPrice;

        // dd($payment, $totalPrice);

        return view('payment.change', compact('payment', 'totalPrice', 'totalChange', 'cashAmount'));
    }

    /**
     * Store a newly created resource in Cart.
     */
    public function storeCart(Request $request)
    {
        try {
            $product = Product::where('product_id', '=', $request->product_id)->firstOrFail();
        } catch (ModelNotFoundException) {
            return redirect()->route('cart')->with('error', 'Product barcode not exist!');
        }
        // dd($request, $product);
        // dd($product->id);
        // If product already exist in cart, update quantity
        $cartExist = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.id', 'carts.product_id', 'carts.quantity', 'carts.user_id', 'carts.payment_id')
            ->where('carts.user_id', '=', auth()->user()->id)
            ->where('carts.product_id', '=', $product->id)
            ->where('carts.payment_id', '=', null)
            ->first();
        
        // dd($cartExist);
        
        if ($cartExist) {
            // Check if item quantity is more than stock
            if ($cartExist->quantity >= $product->product_quantity) {
                return redirect()->route('cart')->with('error', 'Product quantity cannot more than stock!');
            } else {
                $cartExist->quantity++;
            }
            // dd($cartExist->quantity, $cartExist->save());
            if ($cartExist->save()) {
                return redirect()->route('cart')->with('success', 'Product added to cart successfully!');
            } else {
                return redirect()->route('cart')->with('error', 'Failed to add product to cart!');
            }
        }

        // If product quantity = 0, cannot add to cart
        if ($product->product_quantity <= 0) {
            return redirect()->route('cart')->with('error', 'Product out of stock!');
        }

        $cart = new Cart();
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $product->id;

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
     * Store a newly created resource in Payment.
     */
    public function storePayment(Request $request)
    {
        // check whether amount is enough or not
        if ($request->cash_amount < $request->total_price) {
            return redirect()->back()->with('error', 'Amount Paid is not enough!');
        }

        $payment = new Payment();
        $payment->total_price = $request->total_price;
        $payment->payment_method = $request->payment_method;
        $payment->cash_amount = $request->cash_amount;
        $payment->save();

        $carts = Cart::where('user_id', '=', auth()->user()->id)
            ->where('payment_id', '=', null)
            ->get();
        
        // Update product quantity in product table
        $carts->each(function ($cart) {
            $product = Product::find($cart->product_id);
            $product->product_quantity -= $cart->quantity;
            $product->save();
        });

        $carts->each(function ($cart) use ($payment) {
            $cart->payment_id = $payment->id;
            $cart->save();
        });

        return redirect()->route('payment.change', $payment->id)->with('success', 'Payment success!');
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

        // Check if item quantity is more than stock
        if ($cart->quantity >= $cart->product->product_quantity) {
            return redirect()->back()->with('error', 'Product quantity cannot more than stock!');
        } else {
            $cart->quantity++;
        }

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

    /**
     * Remove the all from Cart.
     */
    public function destroyAll()
    {
        $carts = Cart::where('user_id', '=', auth()->user()->id)
            ->where('payment_id', '=', null)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Cart is empty!');
        }

        // dd($carts);

        foreach ($carts as $cart) {
            $cart->delete();
        }

        return redirect()->route('cart')->with('success', 'All product deleted from cart successfully!');
    }
}
