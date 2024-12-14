<x-app-layout>
    <div class="flex flex-col h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Payment
        </div>

        {{-- Content --}}
        <div class="flex flex-col bg-white border border-slate-300 rounded-xl px-5 py-3 gap-y-11 mt-10"
            style="min-height: 60%; max-height:  80%;">
            <div class="font-bold text-lg">
                Payment
            </div>

            {{-- Message --}}
            @if (session('success'))
                <div class="bg-green-200 text-green-800 px-4 py-2 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-200 text-red-800 px-4 py-2 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <span class="font-bold">Total Price:&nbsp;&nbsp;</span>
                <span class="font-light">RM&nbsp;&nbsp;</span>
                <span class="font-bold">{{ number_format($totalPrice, 2) }}</span>
            </div>
            <form action="{{ route('payment.store') }}" method="post" class="h-full w-full">
                @csrf
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                <div class="flex flex-row mt-7 gap-x-40">
                    <div>
                        <div class="font-semibold">
                            Payment Method
                        </div>
                        <div class="mt-4">
                            <input type="radio" name="payment_method" required value="Cash">
                            <label for="cash">Cash</label>
                        </div>
                        <div class="mt-3">
                            <input type="radio" name="payment_method" value="QR">
                            <label for="card">QR Pay</label>
                        </div>
                    </div>


                    <div>
                        <div class="font-semibold">
                            Paid Amount
                        </div>
                        <div class="mt-4">
                            <span class="font-light">RM&nbsp;&nbsp;</span>
                            <input class="text-center rounded-xl border-x-0 border-t-0 w-auto" type="number"
                                name="cash_amount" id="cash_amount" step="0.01" min="0.01" max="999999.99"
                                required autofocus value="{{ number_format($totalPrice, 2, '.', '') }}">
                        </div>
                    </div>
                </div>

                {{-- Go back previous page script --}}
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                {{-- Buttons --}}
                <div class="mt-10 mb-5 flex flex-row justify-between">
                    <div class="ml-auto mr-16">
                        <button class="w-24 px-4 py-2 bg-gray-200 rounded-xl font-bold"
                            onclick="goBack()">Cancel</button>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-24 px-4 py-2 bg-ump-green text-white rounded-xl font-bold ml-4 mr-10">Proceed</button>
                    </div>
                </div>
            </form>
        </div>
</x-app-layout>
