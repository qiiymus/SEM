<x-app-layout>
    <div class="flex flex-col justify-evenly gap-y-3 h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Payment
        </div>

        {{-- Content --}}
        <div class="flex flex-col justify-evenly bg-white border border-slate-300 rounded-xl px-5 py-3"
            style="min-height: 83.333333%; max-height:  83.333333%;">
            <div class="font-bold text-lg">
                Cart
            </div>
            <div>
                <form action="#" method="post">
                    @csrf
                    <input type="text" name="test" id="test" placeholder="Enter Barcode..."
                        class="text-center rounded-xl border-x-0 border-t-0">
                    <input type="submit" value="Add Item" class="ml-6 p-2 rounded-xl text-white bg-ump-green">
                </form>
            </div>
            {{-- Table --}}
            <div class="overflow-hidden mt-5">
                <div class="max-h-72 mx-2 overflow-y-auto">
                    <table class="min-w-full table-auto">
                        <thead class="sticky top-0 bg-white">
                            <tr>
                                <th class="text-left py-2 px-2">Item ID</th>
                                <th class="text-left py-2 px-2">Name</th>
                                <th class="text-left py-2 px-2">Price</th>
                                <th class="text-left py-2 px-2">Quantity</th>
                                <th class="text-left py-2 px-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr class="border-t border-slate-400 bg-gray-100">
                                    <td class="py-2 px-2">{{ $cart->id }}</td>
                                    <td class="py-2 px-2">{{ $cart->product_name }}</td>
                                    <td class="py-2 px-2">
                                        <span>RM&nbsp;&nbsp;</span>
                                        <span class="font-bold">{{ $cart->product_price }}</span>
                                    </td>
                                    <td class="py-2 px-2 flex justify-between" style="max-width: 70%">
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="lightgreen" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                            </svg>
                                        </a>
                                        <span>{{ $cart->quantity }}</span>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="lightgreen" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="red" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- After table --}}
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
            <div class="mt-5 flex flex-row justify-between items-center">
                <div>
                    <span class="font-bold">Total Price:&nbsp;&nbsp;</span>
                    <span class="font-light">RM&nbsp;&nbsp;</span>
                    <span class="font-bold">{{ $totalPrice }}</span>
                </div>
                <div class="ml-auto mr-10">
                    <button class="w-20 px-4 py-2 bg-gray-200 rounded-xl font-bold" onclick="goBack()">Cancel</button>
                </div>
                <div>
                    <a href="ml-auto">
                        <button class="w-20 px-4 py-2 bg-ump-green text-white rounded-xl font-bold">Pay</button>
                    </a>
                </div>
            </div>

        </div>
</x-app-layout>
