<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        try {
            $products = Product::all();
            
            // Get products with low stock (quantity <= 5)
            $alert = Product::where('product_quantity', '<=', 5)->get();
            
            return view('products.viewInventory', compact('products', 'alert'));
            
        } catch (Exception $e) {
            Log::error('Error fetching products:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Unable to fetch products. Please try again.');
        }
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
    DB::beginTransaction();
    try {
        $validated = $request->validated();
        
        // Format numerical values
        $validated['cost'] = number_format((float)$validated['cost'], 2, '.', '');
        $validated['price'] = number_format((float)$validated['price'], 2, '.', '');
        
        $product = new Product();
        $product->product_id = $validated['product_id'];
        $product->product_name = $validated['name'];
        $product->product_cost = $validated['cost'];
        $product->product_price = $validated['price'];
        $product->product_quantity = $validated['quantity'];
        $product->product_category = $validated['category'];
        $product->product_brand = $validated['brand'];
        
        $product->save();
        
        DB::commit();
        
        // Updated route name to match web.php
        return redirect()
            ->route('product')  // Changed to match your actual route name
            ->with('success', 'Product added successfully');
            
    } catch (QueryException $e) {
        DB::rollBack();
        
        Log::error('Database error while storing product:', [
            'error' => $e->getMessage(),
            'sql' => $e->getSql(),
            'bindings' => $e->getBindings(),
            'data' => $validated ?? $request->all(),
            'user_id' => auth()->id()
        ]);
        
        if ($e->getCode() == 23000) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'This product ID already exists. Please use a different one.');
        }
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Database error occurred while saving the product. Please try again.');
            
    } catch (Exception $e) {
        DB::rollBack();
        
        Log::error('Unexpected error while storing product:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validated ?? $request->all(),
            'user_id' => auth()->id()
        ]);
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'An unexpected error occurred. Please try again.');
    }
}

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.updateInventory', compact('product'));
            
        } catch (Exception $e) {
            Log::error('Error fetching product for edit:', [
                'error' => $e->getMessage(),
                'product_id' => $id
            ]);
            
            return redirect()
                ->route('product.index')
                ->with('error', 'Product not found.');
        }
    }

    /**
     * Update the specified product in database.
     */
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            
            // Format numerical values
            $validated['cost'] = number_format((float)$validated['cost'], 2, '.', '');
            $validated['price'] = number_format((float)$validated['price'], 2, '.', '');
            
            $product->update([
                'product_id' => $validated['product_id'],
                'product_name' => $validated['name'],
                'product_cost' => $validated['cost'],
                'product_price' => $validated['price'],
                'product_quantity' => $validated['quantity'],
                'product_category' => $validated['category'],
                'product_brand' => $validated['brand']
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('product.index')  
                ->with('success', 'Product updated successfully');
                
        } catch (QueryException $e) {
            DB::rollBack();
            
            Log::error('Database error while updating product:', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'data' => $validated ?? $request->all(),
                'product_id' => $product->id,
                'user_id' => auth()->id()
            ]);
            
            if ($e->getCode() == 23000) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'This product ID is already in use by another product.');
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error occurred while updating the product. Please try again.');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Unexpected error while updating product:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated ?? $request->all(),
                'product_id' => $product->id,
                'user_id' => auth()->id()
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
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            
            return redirect()
                ->route('product.index')  // Updated route name
                ->with('success', 'Product deleted successfully');
                
        } catch (Exception $e) {
            Log::error('Error deleting product:', [
                'error' => $e->getMessage(),
                'product_id' => $id
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Unable to delete product. Please try again.');
        }
    }
}