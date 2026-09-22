<x-app-layout>
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Assign Homework</h2>
            <p class="text-sm font-medium text-gray-500">Create a new assignment for students</p>
        </div>
        <a href="{{ route('academic.homework.index') }}" class="px-4 py-2 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
            Back
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <form action="{{ route('academic.homework.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Class</label>
                    <select name="school_class_id" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                        <option value="">Select a class...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('school_class_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Subject</label>
                    <select name="subject_id" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                        <option value="">Select a subject...</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Teacher</label>
                    <select name="teacher_id" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                        <option value="">Select a teacher...</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Assignment Title</label>
                <input type="text" name="title" required placeholder="e.g. Chapter 4 Math Exercises" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Description & Instructions</label>
                <textarea name="description" rows="4" placeholder="Provide detailed instructions for the students..." class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50"></textarea>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Due Date</label>
                <input type="date" name="due_date" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                @error('due_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-black text-lg rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all transform hover:-translate-y-1">
                    Assign Homework
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
