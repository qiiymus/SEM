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
    public function store(ProductRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $product = new Product();
            $product->product_id = $validated['product_id'];
            $product->product_name = $validated['name'];
            $product->product_cost = number_format($validated['cost'], 2, '.', '');
            $product->product_price = number_format($validated['price'], 2, '.', '');
            $product->product_quantity = $validated['quantity'];
            $product->product_category = $validated['category'];
            $product->product_brand = $validated['brand'];
            
            $product->save();
            
            return redirect()
                ->route('product')
                ->with('success', 'Product added successfully');
                
        } catch (QueryException $e) {
            Log::error('Database error while storing product:', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error occurred while saving the product. Please try again.');
                
        } catch (Exception $e) {
            Log::error('Unexpected error while storing product:', [
                'error' => $e->getMessage(),
                'data' => $validated ?? $request->all()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
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
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();
            
            $product->update([
                'product_id' => $validated['product_id'],
                'product_name' => $validated['name'],
                'product_cost' => number_format($validated['cost'], 2, '.', ''),
                'product_price' => number_format($validated['price'], 2, '.', ''),
                'product_quantity' => $validated['quantity'],
                'product_category' => $validated['category'],
                'product_brand' => $validated['brand']
            ]);
            
            return redirect()
                ->route('product')
                ->with('success', 'Product updated successfully');
                
        } catch (QueryException $e) {
            Log::error('Database error while updating product:', [
                'error' => $e->getMessage(),
                'data' => $validated,
                'product_id' => $product->id
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error occurred while updating the product. Please try again.');
                
        } catch (Exception $e) {
            Log::error('Unexpected error while updating product:', [
                'error' => $e->getMessage(),
                'data' => $validated ?? $request->all(),
                'product_id' => $product->id
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
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
