<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students') }}
            </h2>
            <a href="{{ route('students.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Add Student
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
                                <th class="px-4 py-3 border-b">Roll</th>
                                <th class="px-4 py-3 border-b">Name</th>
                                <th class="px-4 py-3 border-b">Class</th>
                                <th class="px-4 py-3 border-b">Phone</th>
                                <th class="px-4 py-3 border-b text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-3">
                                        @if($student->image)
                                            <img src="{{ asset('storage/' . $student->image) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">No</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $student->roll }}</td>
                                    <td class="px-4 py-3 font-semibold">
                                        <a href="{{ route('students.show', $student) }}" class="text-primary hover:underline">
                                            {{ $student->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">Class {{ $student->schoolClass->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $student->phone ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('students.id-card', $student) }}" class="text-green-600 hover:text-green-800 font-bold text-xs bg-green-50 px-3 py-1 rounded-lg mr-2 inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            ID Card
                                        </a>
                                        <a href="{{ route('students.dues', $student) }}" class="text-orange-500 hover:underline mr-3 font-bold text-sm">Dues</a>
                                        <a href="{{ route('students.edit', $student) }}" class="text-primary hover:underline mr-3 text-sm">Edit</a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline text-sm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
