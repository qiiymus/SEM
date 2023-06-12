<x-app-layout>
    {{-- Define printable object --}}
    <style>
        @media print {

            body *,
            #afterTable,
            div {
                visibility: hidden;
            }

            #printable,
            #printable * {
                visibility: visible;
                overflow: visible;
            }

            #printable {
                position: absolute;
                top: 0;
                margin: 0;
                padding: 0;
            }

            thead.sticky {
                position: static;
            }

            thead.top-0 {
                top: auto;
            }

            #buttonP {
                display: none;
            }
        }
    </style>

    <div class="flex flex-col justify-evenly gap-y-3 h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Change
        </div>

        {{-- Message --}}
        @if (session('success'))
            <div class="mt-1 bg-green-200 text-green-800 px-4 py-2 mb-1 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-1 bg-red-200 text-red-800 px-4 py-2 mb-1 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        {{-- Content --}}
        <div id="printable" class="flex flex-col bg-white border border-slate-300 rounded-xl px-5 py-3"
            style="min-height: 83.333333%; max-height:  83.333333%;">
            <div class="font-bold text-lg">
                Payment
            </div>
            <div class="mt-1">
                <span>Payment ID:&nbsp;</span>
                <span class="font-bold">{{ $payment[0]->id }}</span>
            </div>

            {{-- Table --}}
            <div class="mt-5">
                <div id="printTable" class="mx-2 overflow-y-auto" style="max-height: 17rem;">
                    <table class="min-w-full table-auto">
                        <thead class="sticky top-0 bg-white">
                            <tr>
                                <th class="text-left py-2 px-2">Item Barcode</th>
                                <th class="text-left py-2 px-2">Name</th>
                                <th class="text-left py-2 px-2">Quantity</th>
                                <th class="text-left py-2 px-2">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment as $pay)
                                <tr class="border-t border-slate-400 bg-gray-100">
                                    <td class="py-2 px-2">{{ $pay->product_id }}</td>
                                    <td class="py-2 px-2">{{ $pay->product_name }}</td>
                                    <td class="py-2 px-2">{{ $pay->quantity }}</td>
                                    <td class="py-2 px-2">
                                        <span>RM&nbsp;&nbsp;</span>
                                        <span class="font-bold">{{ number_format($pay->product_price, 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- After table --}}
            <div id="afterTable" class="mt-auto flex flex-col justify-between">
                <div class="ml-auto mr-10">
                    <span class="font-bold">Total Price:&nbsp;&nbsp;</span>
                    <span class="font-light">RM&nbsp;&nbsp;</span>
                    <span class="font-bold">{{ number_format($totalPrice, 2) }}</span>
                </div>

                <div class="ml-auto mr-10">
                    <span class="font-bold">Amount Paid:&nbsp;&nbsp;</span>
                    <span class="font-light">RM&nbsp;&nbsp;</span>
                    <span class="font-bold">{{ number_format($cashAmount, 2) }}</span>
                </div>

                <div class="ml-auto mr-10">
                    <span class="font-bold">Total Change:&nbsp;&nbsp;</span>
                    <span class="font-light">RM&nbsp;&nbsp;</span>
                    <span class="font-bold">{{ number_format($totalChange, 2) }}</span>
                </div>
            </div>

            {{-- Buttons --}}
            {{-- Print dialog --}}
            <script>
                function printPage() {
                    window.print();
                }
            </script>

            <div id="buttonP" class="mt-auto mb-3 flex flex-row justify-between place-items-end">
                <div class="ml-auto mr-10">
                    <a href="{{ route('cart') }}">
                        <button class="w-32 px-4 py-2 bg-gray-200 rounded-xl font-bold">Back to Cart</button>
                    </a>
                </div>
                <div>
                    <button class="w-32 px-4 py-2 bg-ump-green text-white rounded-xl font-bold"
                        onclick="printPage()">Print</button>
                </div>
            </div>

        </div>
</x-app-layout>
