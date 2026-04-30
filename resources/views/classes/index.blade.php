<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Classes') }}
            </h2>
            <a href="{{ route('classes.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Add Class
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
                                <th class="px-4 py-3 border-b">Class Name</th>
                                <th class="px-4 py-3 border-b">Monthly Fee</th>
                                <th class="px-4 py-3 border-b">Admission Fee</th>
                                <th class="px-4 py-3 border-b">Students</th>
                                <th class="px-4 py-3 border-b">Subjects</th>
                                <th class="px-4 py-3 border-b text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $class)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-3">{{ $class->id }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $class->name }}</td>
                                    <td class="px-4 py-3">৳{{ number_format($class->feeStructures->where('fee_type', 'Monthly Fee')->first()->amount ?? 0, 2) }}</td>
                                    <td class="px-4 py-3">৳{{ number_format($class->feeStructures->where('fee_type', 'Admission Fee')->first()->amount ?? 0, 2) }}</td>
                                    <td class="px-4 py-3">{{ $class->students_count }}</td>
                                    <td class="px-4 py-3">{{ $class->subjects_count }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('classes.edit', $class) }}" class="text-primary hover:underline mr-3">Edit</a>
                                        <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No classes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
