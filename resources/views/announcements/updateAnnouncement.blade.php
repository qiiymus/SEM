<x-app-layout>
    {{-- Title --}}
    <div class="font-extrabold text-xl mt-2">
        Update Announcement
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('updateAnnouncement', $announcement->id) }}" method="POST">                       
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ $announcement->title }}" required autofocus />                           
                            @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="desc" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="desc" id="desc" class="form-textarea rounded-md shadow-sm mt-1 block w-full"
                                rows="4" required>{{ $announcement->description }}
                            </textarea>
                            @error('desc')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end px-4 py-2">
                            <div class="px-4">
                                <button type="button" onclick="resetForm()" class="btn border border-slate-400 bg-gray-400 px-3 py-2 rounded-xl hover:bg-gray-300">Reset</button>
                                <script>
                                    function resetForm() {
                                        document.getElementById("title").value = "";
                                        document.getElementById("desc").value = "";
                                    }
                                </script>                                
                            </div>
                            <div class="px-4">
                                <input type="submit" value="Save" class="btn btn-success border border-slate-300 bg-emerald-500/80 px-3 py-2 rounded-xl hover:bg-emerald-400/80">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
