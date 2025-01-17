<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $alert = Product::where('product_quantity', '<=', 10)->get();
        return view('products.index', compact('products', 'alert'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|unique:products|regex:/^[A-Za-z0-9\-]+$/',
            'name' => 'required|min:2|max:255',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0|max:999999',
            'category' => 'required|in:food,stationary',
            'brand' => 'required|min:2|max:255',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            if ($request->price < $request->cost) {
                return back()->withInput()->withErrors(['price' => 'Selling price must be greater than or equal to cost price.']);
            }

            $filename = null;
            if ($request->hasFile('product_image')) {
                // Generate a unique filename with timestamp
                $file = $request->file('product_image');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Store the file and get only the filename
                $file->storeAs('images', $filename, 'public');
            }

            Product::create([
                'product_id' => $request->product_id,
                'product_name' => $request->name,
                'product_cost' => $request->cost,
                'product_price' => $request->price,
                'product_quantity' => $request->quantity,
                'product_category' => $request->category,
                'product_brand' => $request->brand,
                'product_image' => $filename  // Store only the filename, not the full path
            ]);

            return redirect()->route('product')->with('success', 'Product added successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Product creation error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error adding product. Please try again.');
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_id' => 'required|regex:/^[A-Za-z0-9\-]+$/|unique:products,product_id,' . $id,
            'name' => 'required|min:2|max:255',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0|max:999999',
            'category' => 'required|in:food,stationary',
            'brand' => 'required|min:2|max:255',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            if ($request->price < $request->cost) {
                return back()->withInput()->withErrors(['price' => 'Selling price must be greater than or equal to cost price.']);
            }

            $imagePath = $product->product_image;
            if ($request->hasFile('product_image')) {
                // Delete old image
                if ($product->product_image) {
                    Storage::disk('public')->delete($product->product_image);
                }
                $imagePath = $request->file('product_image')->store('images', 'public');
            }

            $product->update([
                'product_id' => $request->product_id,
                'product_name' => $request->name,
                'product_cost' => $request->cost,
                'product_price' => $request->price,
                'product_quantity' => $request->quantity,
                'product_category' => $request->category,
                'product_brand' => $request->brand,
                'product_image' => $imagePath
            ]);

            return redirect()->route('product')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating product. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete product image if exists
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }

            $product->delete();
            return redirect()->route('product')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting product. Please try again.');
        }
    }
}