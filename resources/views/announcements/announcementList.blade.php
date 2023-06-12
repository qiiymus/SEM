<x-app-layout>
    <div class="h-full">
        <div class="font-extrabold text-xl mt-2">
            Announcements
        </div>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')     
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full p-4 overflow-y-auto h-4/5">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th class="py-2">ID</th>
                        <th class="py-2">TITLE</th>
                        <th class="py-2">DESCRIPTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($announcements as $announcement)
                        <tr class="bg-gray-200 border-y-8 border-white">
                            <td class="py-2 px-4">{{ $announcement->id }}</td>
                            <td class="py-2 px-4 text-center">{{ $announcement->title }}</td>
                            <td class="py-2 px-4 text-center">{{ $announcement->description }}</td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
