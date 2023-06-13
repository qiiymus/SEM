<x-app-layout>
    <div class="h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Duty Roster
        </div>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
            {{-- Only Cashier can add duty --}}
            @if (Auth::user()->role == 'cashier')
                <a href="{{ route('addDuty') }}" class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                    style="background-color: #00AEA6;">
                    Add Duty
                </a>
            @endif
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full px-4 overflow-y-auto h-4/5 mb-5"
            style="max-height: 26rem">
            <table class="table-auto w-full text-center">
                <thead class="sticky top-0 bg-white">
                    <tr>
                        <th class="p-4">Cashier ID</th>
                        <th class="p-4">Week</th>
                        <th class="p-4">Start Time</th>
                        <th class="p-4">End Time</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dispaly all added duty roster --}}
                    @foreach ($dutyRoster as $item)
                        <tr class="bg-gray-200 border-y-8 border-white">
                            <td class="py-2">{{ $item->user_id }}</td>
                            <td class="py-2">{{ $item->week }}</td>
                            <td class="py-2">{{ $item->start_time }}</td>
                            <td class="py-2">{{ $item->end_time }}</td>
                            <td class="flex justify-center">
                                <a href="{{ route('editDuty', $item->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 m-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <script>
                                    function confirmDeleteProduct() {
                                        return confirm('Are you sure you want to delete the product?');
                                    }
                                </script>
                                <form action="{{ route('deleteDuty', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" onclick="return confirmDeleteProduct()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400 m-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</x-app-layout>
