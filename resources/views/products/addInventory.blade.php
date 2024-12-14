<x-app-layout>
    <div class="w-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Add Product
        </div>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
        </div>
        {{-- Error message if there is exsiting product id --}}
        @if (session('error'))
            <div class="bg-red-500 p-1 mx-1 mb-3 rounded-xl text-white text-center">
                {{ session('error') }}
            </div>
        @endif
        <div class="bg-white border border-slate-300 rounded-xl w-full p-3">
            <form action="{{ route('storeInventory') }}" method="post">
                @csrf
                <table class="rounded-xl px-4 w-3/6">
                    <tbody >
                        <tr>
                            <td class="px-4 py-2"><label>Barcode</label></td>
                            <td class="px-4 py-2"><input type="text" name="product_id" class="form-control rounded-xl w-2/5 bg-gray-200 border border-slate-400" required></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Name</label></td>
                            <td class="px-4 py-2"><input type="text" name="name" class="form-control rounded-xl w-full bg-gray-200 border border-slate-400" required></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Cost</label></td>
                            <td class="px-4 py-2"><input type="number" name="cost" class="form-control rounded-xl bg-gray-200 border border-slate-400" step=".01" required></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Price</label></td>
                            <td class="px-4 py-2"><input type="number" name="price" class="form-control rounded-xl bg-gray-200 border border-slate-400" step=".01" required></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Quantity</label></td>
                            <td class="px-4 py-2"><input type="text" name="quantity" class="form-control rounded-xl w-2/6 bg-gray-200 border border-slate-400" required></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Category</label></td>
                            <td class="px-4 py-2"><select name="category" required class="rounded-xl w-2/5 bg-gray-200 border border-slate-400">
                                <option value="food">Food</option>
                                <option value="stationary">Stationary</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Brand</label></td>
                            <td class="px-4 py-2"><input type="text" name="brand" class="form-control rounded-xl w-full bg-gray-200 border border-slate-400" required></td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-end px-4 py-2">
                    <div class="px-4">
                        <input type="reset" value="Reset" class="btn border border-slate-400 bg-gray-400 px-3 py-2 rounded-xl hover:bg-gray-300">
                    </div>
                    <div class="px-4">
                        <input type="submit" value="Save" class="btn btn-success border border-slate-300 bg-emerald-500/80 px-3 py-2 rounded-xl hover:bg-emerald-400/80">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
