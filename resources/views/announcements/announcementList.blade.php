<x-app-layout>
    <div class="h-full">
        <div class="font-extrabold text-xl mt-2">
            Announcements
        </div>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')     
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full p-4 overflow-y-auto h-4/5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($announcements as $announcement)
                    <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <!-- Image -->
                        @if($announcement->announcement_image)
                            <img src="{{ asset('storage/' . $announcement->announcement_image) }}" alt="Announcement Image" class="w-full h-72 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-72 bg-gray-300 flex items-center justify-center rounded-t-xl">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 hover:text-teal-600 transition-colors">{{ $announcement->title }}</h3>
                            <p class="text-gray-600 mt-3 text-sm">{{ Str::limit($announcement->description, 300) }}</p>
                            <div class="mt-4 text-teal-600 font-semibold hover:text-teal-800 transition-colors">
                                <a href="{{ route('showAnnouncement', $announcement->id) }}" class="hover:underline">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
