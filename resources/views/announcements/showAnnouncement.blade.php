<x-app-layout>
    <div class="max-w-4xl mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <!-- Back Button -->
        <a href="{{ route('announcementList') }}" class="text-teal-600 hover:text-teal-800 font-semibold mb-6 inline-block">
            &larr; Back
        </a>
        
        <!-- Image -->
        @if ($announcement->announcement_image)
            <img src="{{ asset('storage/' . $announcement->announcement_image) }}" 
                 alt="Announcement Image" 
                 class="w-1/2 mx-auto h-64 object-cover rounded-lg mb-6">
        @else
            <div class="w-1/2 mx-auto h-64 bg-gray-300 flex items-center justify-center rounded-lg mb-6">
                <span class="text-gray-500 italic">No Image</span>
            </div>
        @endif

        <!-- Title -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
            <p class="text-lg font-semibold text-gray-800 bg-gray-100 p-3 rounded-md">
                {{ $announcement->title }}
            </p>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <p class="text-gray-700 leading-relaxed bg-gray-100 p-3 rounded-md">
                {!! nl2br(e($announcement->description)) !!}
            </p>
        </div>
    </div>
</x-app-layout>
