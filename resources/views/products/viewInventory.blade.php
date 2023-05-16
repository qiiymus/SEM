<x-app-layout>
    <div class="text-left w-full">
        {{-- <table class="text-left border border-slate-500 border-collapse w-full">
            <thead>
                <tr>
                    <th class="border border-slate-500 p-2">
                        Inventory
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-slate-500 p-2">
                        @include('components.searchbar')
                    </td>
                    <td class="border border-slate-500 p-2">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent rounded-lg" style="background-color: #00AEA6;">
                                Add Product
                        </button>
                    </td>
                </tr>
            </tbody>
        </table> --}}
        <p class="text-xl mb-4">Inventory</p>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent rounded-lg"
                style="background-color: #00AEA6;">
                Add Product
            </button>
        </div>
        <div>
            
        </div>
        <p>{{ $products }}</p>
    </div>
</x-app-layout>
