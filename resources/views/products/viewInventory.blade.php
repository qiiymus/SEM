<x-app-layout>
    <div class="w-full">
        <p class="text-xl mb-4">Inventory</p>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
            <a href="{{ route('addInventory') }}"
                class="px-2 py-1 border border-transparent rounded-lg hover:text-gray-600"
                style="background-color: #00AEA6;">
                Add Product
            </a>
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full p-4">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>COST</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>CATEGORY</th>
                        <th>BRAND</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr class="border border-slate-400 rounded-xl">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ number_format($item->product_cost, 2) }}</td>
                            <td>{{ number_format($item->product_price, 2) }}</td>
                            <td>{{ $item->product_quantity }}</td>
                            <td>{{ $item->product_category }}</td>
                            <td>{{ $item->product_brand }}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
