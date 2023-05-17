<x-app-layout>
    <div class="w-full">
        <p class="text-xl mb-4">Inventory</p>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
            <a href="{{ route('addInventory') }}"
                class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;">
                Add Product
            </a>
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full p-4">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th class="py-2">ID</th>
                        <th class="py-2">NAME</th>
                        <th class="py-2">COST</th>
                        <th class="py-2">PRICE</th>
                        <th class="py-2">QUANTITY</th>
                        <th class="py-2">CATEGORY</th>
                        <th class="py-2">BRAND</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr class="border border-slate-400 rounded-xl">
                            <td class="py-2">{{ $item->id }}</td>
                            <td class="py-2">{{ $item->product_name }}</td>
                            <td class="py-2">{{ number_format($item->product_cost, 2) }}</td>
                            <td class="py-2">{{ number_format($item->product_price, 2) }}</td>
                            <td class="py-2">{{ $item->product_quantity }}</td>
                            <td class="py-2">{{ $item->product_category }}</td>
                            <td class="py-2">{{ $item->product_brand }}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
