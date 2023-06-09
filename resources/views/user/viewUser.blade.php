<x-app-layout>
    <div class="flex flex-col gap-y-3 h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            User List
        </div>
        <div class="flex justify-end w-full mb-5 relative right-0">
            <a href="{{ route('addUser') }}"
                class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;">
                Add User
            </a>
        </div>
        {{-- Show session error --}}
        @if (session('error'))
            <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
                {{ session('error') }}
            </div>
        @endif
        {{-- Show session success --}}
        @if (session('success'))
            <div class="bg-green-500 p-4 rounded-lg mb-6 text-white text-center">
                {{ session('success') }}
            </div>
        @endif
        {{-- List all user in table --}}
        {{-- Table --}}
        <div class="mt-5">
            <div class="mx-2 overflow-y-auto" style="max-height: 30rem;">
                <table class="min-w-full table-auto">
                    <thead class="sticky top-0 bg-white">
                        <tr>
                            <th class="text-left py-2 px-2">Matric ID</th>
                            <th class="text-left py-2 px-2">Name</th>
                            <th class="text-left py-2 px-2">Phone Number</th>
                            <th class="text-left py-2 px-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-t border-slate-400 bg-gray-100">
                                <td class="py-2 px-2">{{ $user->matric_id }}</td>
                                <td class="py-2 px-2">{{ $user->name }}</td>
                                <td class="py-2 px-2">{{ $user->phone_num }}</td>
                                <td class="py-2 px-2 flex flex-rol h-auto">
                                    <form action="{{ route('editUser') }}" method="get" class="flex mr-5">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 m-2"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </form>
                                    {{-- Delete User --}}
                                    <form action="{{ route('deleteUser') }}" method="post" class="flex">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="red" stroke-width="2">
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
        </div>
    </div>

</x-app-layout>
