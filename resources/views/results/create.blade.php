<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enter Student Marks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Selection Area -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('results.create') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="class_id" class="block text-sm font-medium text-gray-700">Select Class</label>
                            <select name="class_id" id="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required onchange="this.form.submit()">
                                <option value="" disabled {{ !$selected_class ? 'selected' : '' }}>Choose a class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $selected_class == $class->id ? 'selected' : '' }}>
                                        Class {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">Select Subject</label>
                            <select name="subject_id" id="subject_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required {{ !$selected_class ? 'disabled' : '' }}>
                                <option value="" disabled {{ !$selected_subject ? 'selected' : '' }}>Choose a subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $selected_subject == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Load List
                        </button>
                    </form>
                </div>
            </div>

            @if($selected_class && $selected_subject && count($students) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="{{ route('results.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="subject_id" value="{{ $selected_subject }}">
                            
                            <table class="w-full text-left border-collapse mb-6">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700">
                                        <th class="px-4 py-3 border-b">Roll</th>
                                        <th class="px-4 py-3 border-b">Student Name</th>
                                        <th class="px-4 py-3 border-b">Marks (0-100)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $student->roll }}</td>
                                            <td class="px-4 py-3 font-medium">{{ $student->name }}</td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="marks[{{ $student->id }}]" min="0" max="100" class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="Mark">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-success text-white px-6 py-2 rounded-md hover:bg-green-700 transition font-bold">
                                    Save Results
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($selected_class && $selected_subject)
                <div class="bg-white p-6 text-center text-gray-500 rounded-lg shadow-sm">
                    No students found in this class.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
