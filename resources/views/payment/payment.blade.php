<x-app-layout>
    <div class="flex flex-col h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Payment
        </div>

        {{-- Content --}}
        <div class="flex flex-col bg-white border border-slate-300 rounded-xl px-5 py-3 gap-y-11 mt-10"
            style="min-height: 60%; max-height:  60%;">
            <div class="font-bold text-lg">
                Payment
            </div>

            <div>
                <span class="font-bold">Total Price:&nbsp;&nbsp;</span>
                <span class="font-light">RM&nbsp;&nbsp;</span>
                <span class="font-bold">{{ number_format($totalPrice, 2) }}</span>
            </div>
            <form action="#" method="post">
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
                            Cash Amount
                        </div>
                        <div class="mt-4">
                            <span class="font-light">RM&nbsp;&nbsp;</span>
                            <input class="text-center rounded-xl border-x-0 border-t-0 w-36" type="number"
                                name="cash_amount" id="cash_amount" step="0.01" min="0.01" max="999999.99"
                                required value="{{ $totalPrice }}">
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
                <div class="flex flex-row justify-between mt-auto mb-10 place-items-end">
                    <div class="ml-auto mr-10">
                        <button class="w-24 px-4 py-2 bg-gray-200 rounded-xl font-bold"
                            onclick="goBack()">Cancel</button>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-24 px-4 py-2 bg-ump-green text-white rounded-xl font-bold">Proceed</button>
                    </div>
                </div>
            </form>


        </div>
</x-app-layout>
