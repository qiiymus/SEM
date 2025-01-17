<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        {{-- Header Section --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                {{ isset($product) ? 'Edit Product' : 'Add New Product' }}
            </h1>
            <p class="text-gray-600 mt-1">
                {{ isset($product) ? 'Update the product information below' : 'Fill in the product information below' }}
            </p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Section --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <form action="{{ isset($product) ? route('updateInventory', $product->id) : route('storeInventory') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="productForm" 
                  class="space-y-6 p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Left Column --}}
                    <div class="space-y-6">
                        {{-- Barcode --}}
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Barcode *</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="product_id" 
                                       id="product_id"
                                       value="{{ old('product_id', isset($product) ? $product->product_id : '') }}"
                                       class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Product Name *</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ old('name', isset($product) ? $product->product_name : '') }}"
                                       class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                        </div>

                        {{-- Cost and Price Group --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700">Cost Price *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" 
                                           name="cost" 
                                           id="cost"
                                           step="0.01"
                                           value="{{ old('cost', isset($product) ? $product->product_cost : '') }}"
                                           class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-md"
                                           required>
                                </div>
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Selling Price *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" 
                                           name="price" 
                                           id="price"
                                           step="0.01"
                                           value="{{ old('price', isset($product) ? $product->product_price : '') }}"
                                           class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-md"
                                           required>
                                </div>
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity *</label>
                            <div class="mt-1">
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity"
                                       value="{{ old('quantity', isset($product) ? $product->product_quantity : '') }}"
                                       class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="space-y-6">
                        {{-- Category --}}
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                            <select name="category" 
                                    id="category"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md"
                                    required>
                                <option value="">Select Category</option>
                                <option value="food" {{ old('category', isset($product) ? $product->product_category : '') == 'food' ? 'selected' : '' }}>Food</option>
                                <option value="stationary" {{ old('category', isset($product) ? $product->product_category : '') == 'stationary' ? 'selected' : '' }}>Stationary</option>
                            </select>
                        </div>

                        {{-- Brand --}}
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">Brand *</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="brand" 
                                       id="brand"
                                       value="{{ old('brand', isset($product) ? $product->product_brand : '') }}"
                                       class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                        </div>

                        {{-- Image Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Image {{ isset($product) ? '' : '*' }}</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <div class="flex flex-col items-center">
                                        {{-- Image Preview --}}
                                        <div id="imagePreview" class="mb-4 {{ isset($product) && $product->product_image ? '' : 'hidden' }}">
                                            <img id="preview" 
                                                 src="{{ isset($product) && $product->product_image ? Storage::disk('public')->exists('images/' . $product->product_image) ? asset('storage/images/' . $product->product_image) : asset('images/placeholder.png') : '' }}" 
                                                 alt="Preview" 
                                                 class="h-32 w-32 object-cover rounded-lg">
                                        </div>
                                        {{-- Upload Icon --}}
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="product_image" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                <span>Upload a file</span>
                                                <input id="product_image" 
                                                       name="product_image" 
                                                       type="file" 
                                                       class="sr-only"
                                                       {{ isset($product) ? '' : 'required' }}
                                                       accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="reset" 
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Reset
                    </button>
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        {{ isset($product) ? 'Update Product' : 'Add Product' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('productForm');
            const costInput = document.getElementById('cost');
            const priceInput = document.getElementById('price');
            const imageInput = document.getElementById('product_image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('preview');
            
            // Price validation
            form.addEventListener('submit', function(e) {
                const cost = parseFloat(costInput.value);
                const price = parseFloat(priceInput.value);
                
                if (price < cost) {
                    e.preventDefault();
                    alert('Selling price must be greater than or equal to cost price.');
                    priceInput.focus();
                }
            });

            // Format numbers to 2 decimal places
            [costInput, priceInput].forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            });

            // Image preview
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Drag and drop functionality
            const dropZone = imageInput.closest('div');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-emerald-500');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-emerald-500');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const file = dt.files[0];
                
                if (file && file.type.startsWith('image/')) {
                    imageInput.files = dt.files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            }
        });
    </script>
</x-app-layout>