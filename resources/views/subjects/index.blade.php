<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subjects') }}
            </h2>
            <a href="{{ route('subjects.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Add Subject
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
                                <th class="px-4 py-3 border-b">ID</th>
                                <th class="px-4 py-3 border-b">Subject Name</th>
                                <th class="px-4 py-3 border-b">Class</th>
                                <th class="px-4 py-3 border-b text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-3">{{ $subject->id }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $subject->name }}</td>
                                    <td class="px-4 py-3">Class {{ $subject->schoolClass->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('subjects.edit', $subject) }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-200/60 px-2.5 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
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
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">No subjects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
