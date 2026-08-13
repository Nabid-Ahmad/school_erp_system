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
                                            <img src="{{ filter_var($student->image, FILTER_VALIDATE_URL) ? $student->image : asset('storage/' . $student->image) }}" class="w-10 h-10 rounded-full object-cover">
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
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('students.show', $student) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200/60 px-2.5 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                Profile
                                            </a>
                                            <a href="{{ route('students.id-card', $student) }}" target="_blank" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-200/60 px-2.5 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                                ID Card
                                            </a>
                                            <a href="{{ route('students.dues', $student) }}" class="bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white border border-amber-200/60 px-2.5 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                Dues
                                            </a>
                                            <a href="{{ route('students.edit', $student) }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-200/60 px-2.5 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200/60 px-2.5 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs" onclick="return confirm('Are you sure?')">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
