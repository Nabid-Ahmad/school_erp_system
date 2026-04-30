<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Take Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Class Selection -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('attendances.create') }}" method="GET" class="flex items-end gap-4">
                        <div class="flex-1">
                            <label for="class_id" class="block text-sm font-medium text-gray-700">Select Class</label>
                            <select name="class_id" id="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required>
                                <option value="" disabled {{ !$selected_class ? 'selected' : '' }}>Choose a class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $selected_class == $class->id ? 'selected' : '' }}>
                                        Class {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" value="{{ $selected_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required>
                        </div>
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Load Students
                        </button>
                    </form>
                </div>
            </div>

            @if($selected_class && count($students) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="{{ route('attendances.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="date" value="{{ $selected_date }}">
                            
                            <table class="w-full text-left border-collapse mb-6">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700">
                                        <th class="px-4 py-3 border-b">Roll</th>
                                        <th class="px-4 py-3 border-b">Student Name</th>
                                        <th class="px-4 py-3 border-b text-center">Present</th>
                                        <th class="px-4 py-3 border-b text-center">Absent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $student->roll }}</td>
                                            <td class="px-4 py-3 font-medium">{{ $student->name }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="present" class="text-success focus:ring-success" checked required>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="text-danger focus:ring-danger">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-success text-white px-6 py-2 rounded-md hover:bg-green-700 transition font-bold">
                                    Submit Attendance
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($selected_class)
                <div class="bg-white p-6 text-center text-gray-500 rounded-lg shadow-sm">
                    No students found in this class.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
