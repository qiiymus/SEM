<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::all();
        /**If inventory is low in stock, return alert message */
        $alert = Product::where('product_quantity', '<=', 5)->get();

        if (count($alert) <= 0) {
            $alert = null;
        }
        return view('products.viewInventory', compact('products', 'alert'));
    }

    /**
     * Show the form for adding a new product.
     */
    public function create()
    {
        return view('products.addInventory');
    }

    /**
     * Store a newly added product in storage.
     */
    public function store(Request $request)
    {
        // $product = new Product();
        // Product::orderby('id')->get();
        // $product->product_id = $request->product_id;
        // $product->product_name = $request->name;
        // $cost = $request->cost;
        // $cost = number_format($cost, 2, '.', '');
        // $product->product_cost = $cost;
        // $product->product_price = $request->price;
        // $price = $request->price;
        // $price = number_format($price, 2, '.', '');
        // $product->product_price = $price;
        // $product->product_quantity = $request->quantity;
        // $product->product_category = $request->category;
        // $product->product_brand = $request->brand;
        // $product->save();
        // return redirect()->route('product')->with('success', 'Product added successfully');

        // Error message if there is existing product id

        $existingProduct = Product::where('product_id', $request->product_id)->first();

        if ($existingProduct != null) {
            return redirect()->route('addInventory')->with('error', 'Barcode already exists.');
        }

        $product = new Product();
        Product::orderby('id')->get();
        $product->product_id = $request->product_id;
        $product->product_name = $request->name;
        $cost = $request->cost;
        $cost = number_format($cost, 2, '.', '');
        $product->product_cost = $cost;
        $product->product_price = $request->price;
        $price = $request->price;
        $price = number_format($price, 2, '.', '');
        $product->product_price = $price;
        $product->product_quantity = $request->quantity;
        $product->product_category = $request->category;
        $product->product_brand = $request->brand;
        $product->save();
        return redirect()->route('product')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.updateInventory', compact('product'));
    }

    /**
     * Update the specified product in databse.
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::find($request->id);
        $product->product_id = $request->product_id;
        $product->product_name = $request->name;
        $cost = $request->cost;
        $cost = number_format($cost, 2, '.', '');
        $product->product_cost = $cost;
        $product->product_price = $request->price;
        $price = $request->price;
        $price = number_format($price, 2, '.', '');
        $product->product_price = $price;
        $product->product_quantity = $request->quantity;
        $product->product_category = $request->category;
        $product->product_brand = $request->brand;
        $product->save();
        return redirect()->route('product')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product from database.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product')->with('success', 'Product deleted successfully');
    }
}
