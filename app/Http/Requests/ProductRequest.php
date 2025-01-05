<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|string|max:50|unique:products,product_id,' . ($this->product ? $this->product->id : ''),
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0|decimal:0,2',
            'price' => 'required|numeric|min:0|decimal:0,2|gte:cost',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|in:food,stationary',
            'brand' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.unique' => 'This product ID/barcode is already in use.',
            'price.gte' => 'The selling price must be greater than or equal to the cost price.',
            'cost.decimal' => 'The cost must have 2 or fewer decimal places.',
            'price.decimal' => 'The price must have 2 or fewer decimal places.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity cannot be negative.',
        ];
    }
}