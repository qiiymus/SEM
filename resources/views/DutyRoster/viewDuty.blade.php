<x-app-layout>
    <div class="h-full">
        <p class="text-xl mb-4">Duty Roster</p>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
            <a href="{{ route('addDuty') }}" 
                class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;">
                Add Duty
            </a>
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full p-4 overflow-y-auto h-4/5">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th class="py-2">User ID</th>
                        <th class="py-2">User Name</th>
                        <th class="py-2">Week</th>
                        <th class="py-2">Date</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Start Time</th>
                        <th class="py-2">End Time</th>
                        <th class="py-2">Created At</th>
                        <th class="py-2">Updated At</th>
                        <th class="py-2">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($dutyRoster as $item)
                        <tr class="bg-gray-200 border-y-8 border-white">
                            <td class="py-2">{{ $item->user_id }}</td>
                            <td class="py-2">{{ $item->user_name }}</td>
                            <td class="py-2">{{ $item->week }}</td>
                            <td class="py-2">{{ $item->date }}</td>
                            <td class="py-2">{{ $item->status }}</td>
                            <td class="py-2">{{ $item->start_time }}</td>
                            <td class="py-2">{{ $item->end_time }}</td>
                            <td class="py-2">{{ $item->created_at }}</td>
                            <td class="py-2">{{ $item->updated_at }}</td>
                            <td class="flex justify-center">
                                <a href="{{ route('editDuty', $item->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 m-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <script>
                                    function confirmDeleteDuty() {
                                        return confirm('Are you sure you want to delete the Duty?');
                                    }
                                </script> 
                                <form action="{{ route('deleteDuty', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" onclick="return confirmDeleteDuty()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400 m-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form> 
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
