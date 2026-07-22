<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teachers') }}
            </h2>
            <a href="{{ route('teachers.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Add Teacher
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="px-4 py-3 border-b">Photo</th>
                                <th class="px-4 py-3 border-b">ID</th>
                                <th class="px-4 py-3 border-b">Name</th>
                                <th class="px-4 py-3 border-b">Subject</th>
                                <th class="px-4 py-3 border-b">Phone</th>
                                <th class="px-4 py-3 border-b text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-3">
                                        @if($teacher->image)
                                            <img src="{{ filter_var($teacher->image, FILTER_VALIDATE_URL) ? $teacher->image : asset('storage/' . $teacher->image) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">No</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $teacher->id }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $teacher->name }}</td>
                                    <td class="px-4 py-3">{{ $teacher->subject }}</td>
                                    <td class="px-4 py-3">{{ $teacher->phone ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex justify-end items-center gap-3">
                                            <a href="{{ route('teachers.show', $teacher->id) }}" class="text-blue-600 font-bold hover:underline">Profile</a>
                                            <a href="{{ route('teachers.id-card', $teacher->id) }}" target="_blank" class="text-green-600 font-bold hover:underline">ID Card</a>
                                            <a href="{{ route('teachers.edit', $teacher) }}" class="text-primary font-bold hover:underline">Edit</a>
                                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger font-bold hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No teachers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
