<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view ('products.viewInventory')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.addInventory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $input = $request->all();
        // Product::create($input);
        // return redirect()->route('product')->with('success', 'Product added successfully');
        $product = new Product();
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
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
