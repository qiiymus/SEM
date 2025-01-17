<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Trim whitespace from string inputs
        $this->merge([
            'product_id' => trim($this->product_id),
            'name' => trim($this->name),
            'brand' => trim($this->brand),
        ]);
    }

    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'product_id')->ignore($this->product?->id),
                'regex:/^[A-Za-z0-9-]+$/' // Only allow alphanumeric and hyphens
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
            'cost' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
                'regex:/^\d*\.?\d{0,2}$/' // Ensure exactly 2 decimal places
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
                'gte:cost',
                'regex:/^\d*\.?\d{0,2}$/' // Ensure exactly 2 decimal places
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0',
                'max:999999' // Reasonable upper limit
            ],
            'category' => [
                'required',
                'string',
                Rule::in(['food', 'stationary']),
            ],
            'brand' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'A product ID/barcode is required.',
            'product_id.unique' => 'This product ID/barcode is already in use.',
            'product_id.regex' => 'The product ID/barcode may only contain letters, numbers, and hyphens.',
            'name.required' => 'The product name is required.',
            'name.min' => 'The product name must be at least 2 characters.',
            'price.gte' => 'The selling price must be greater than or equal to the cost price.',
            'cost.decimal' => 'The cost must have exactly 2 decimal places.',
            'cost.regex' => 'The cost must have exactly 2 decimal places.',
            'price.decimal' => 'The price must have exactly 2 decimal places.',
            'price.regex' => 'The price must have exactly 2 decimal places.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity cannot be negative.',
            'quantity.max' => 'The quantity cannot exceed 999,999 units.',
            'category.in' => 'Please select a valid category.',
            'brand.required' => 'The brand name is required.',
            'brand.min' => 'The brand name must be at least 2 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'product ID/barcode',
            'name' => 'product name',
            'cost' => 'cost price',
            'price' => 'selling price',
            'quantity' => 'quantity',
            'category' => 'product category',
            'brand' => 'brand name',
        ];
    }
}