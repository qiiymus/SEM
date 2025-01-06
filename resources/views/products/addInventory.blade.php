<x-app-layout>
    <div class="w-full">
        <div class="font-extrabold text-xl mt-2">
            {{ isset($product) ? 'Edit Product' : 'Add Product' }}
        </div>
        
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
        </div>

        {{-- Validation Errors Summary --}}
        @if ($errors->any() || session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Please correct the following issues:</p>
                @if(session('error'))
                    <p>{{ session('error') }}</p>
                @endif
                @if ($errors->any())
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white border border-slate-300 rounded-xl w-full p-3">
        <form action="{{ route('product.store') }}" method="POST">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif
                
                <table class="rounded-xl px-4 w-3/6">
                    <tbody>
                        {{-- Product ID --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="product_id" class="block text-sm font-medium text-gray-700">Barcode *</label>
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" 
                                    id="product_id"
                                    name="product_id" 
                                    class="form-control rounded-xl w-2/5 border @error('product_id') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    value="{{ old('product_id', $product->product_id ?? '') }}"
                                    required
                                    pattern="[A-Za-z0-9-]+"
                                    title="Only letters, numbers, and hyphens are allowed">
                                @error('product_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Only letters, numbers, and hyphens are allowed</p>
                            </td>
                        </tr>

                        {{-- Name --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" 
                                    id="name"
                                    name="name" 
                                    class="form-control rounded-xl w-full border @error('name') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    value="{{ old('name', $product->product_name ?? '') }}"
                                    required
                                    minlength="2"
                                    maxlength="255">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- Cost --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="cost" class="block text-sm font-medium text-gray-700">Cost *</label>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" 
                                    id="cost"
                                    name="cost" 
                                    class="form-control rounded-xl border @error('cost') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    step="0.01" 
                                    min="0"
                                    value="{{ old('cost', $product->product_cost ?? '') }}"
                                    required>
                                @error('cost')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Enter amount with exactly 2 decimal places</p>
                            </td>
                        </tr>

                        {{-- Price --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price *</label>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" 
                                    id="price"
                                    name="price" 
                                    class="form-control rounded-xl border @error('price') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    step="0.01" 
                                    min="0"
                                    value="{{ old('price', $product->product_price ?? '') }}"
                                    required>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Must be greater than or equal to cost price</p>
                            </td>
                        </tr>

                        {{-- Quantity --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity *</label>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" 
                                    id="quantity"
                                    name="quantity" 
                                    class="form-control rounded-xl w-2/6 border @error('quantity') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    value="{{ old('quantity', $product->product_quantity ?? '') }}"
                                    min="0"
                                    max="999999"
                                    step="1"
                                    required>
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Must be a whole number between 0 and 999,999</p>
                            </td>
                        </tr>

                        {{-- Category --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                            </td>
                            <td class="px-4 py-2">
                                <select name="category" 
                                    id="category"
                                    class="rounded-xl w-2/5 border @error('category') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    required>
                                    <option value="">Select a category</option>
                                    <option value="food" {{ old('category', $product->product_category ?? '') == 'food' ? 'selected' : '' }}>Food</option>
                                    <option value="stationary" {{ old('category', $product->product_category ?? '') == 'stationary' ? 'selected' : '' }}>Stationary</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- Brand --}}
                        <tr>
                            <td class="px-4 py-2">
                                <label for="brand" class="block text-sm font-medium text-gray-700">Brand *</label>
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" 
                                    id="brand"
                                    name="brand" 
                                    class="form-control rounded-xl w-full border @error('brand') border-red-500 bg-red-50 @else border-slate-400 bg-gray-200 @enderror" 
                                    value="{{ old('brand', $product->product_brand ?? '') }}"
                                    required
                                    minlength="2"
                                    maxlength="255">
                                @error('brand')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-end px-4 py-2 space-x-4">
                    <button type="button" 
                            onclick="if(confirm('Are you sure you want to reset the form?')) { this.form.reset(); }"
                            class="btn border border-slate-400 bg-gray-400 px-4 py-2 rounded-xl hover:bg-gray-300 transition-colors">
                        Reset
                    </button>
                    
                    <button type="submit" 
                            class="btn btn-success border border-slate-300 bg-emerald-500/80 px-4 py-2 rounded-xl hover:bg-emerald-400/80 transition-colors">
                        {{ isset($product) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add client-side validation script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const costInput = document.getElementById('cost');
            const priceInput = document.getElementById('price');
            
            // Validate price is >= cost
            form.addEventListener('submit', function(e) {
                const cost = parseFloat(costInput.value);
                const price = parseFloat(priceInput.value);
                
                if (price < cost) {
                    e.preventDefault();
                    alert('Selling price must be greater than or equal to cost price.');
                    priceInput.focus();
                }
            });

            // Format decimal inputs to always show 2 decimal places
            [costInput, priceInput].forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            });
        });
    </script>
</x-app-layout>
