<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $homework->title }}</h2>
            <p class="text-sm font-medium text-gray-500">Subject: {{ $homework->subject->name }} | Teacher: {{ optional($homework->teacher)->name }}</p>
        </div>
        <a href="{{ route('student.homework.index') }}" class="px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
            Back to My Homework
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Assignment Instructions -->
        <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden p-8 space-y-6">
            <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4">Assignment Details</h3>
            <div>
                <h4 class="text-[10px] font-black uppercase text-purple-300 tracking-widest mb-1">Due Date</h4>
                <div class="font-bold text-lg {{ \Carbon\Carbon::parse($homework->due_date)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                    {{ \Carbon\Carbon::parse($homework->due_date)->format('l, F j, Y') }}
                </div>
            </div>
            <div>
                <h4 class="text-[10px] font-black uppercase text-purple-300 tracking-widest mb-2">Instructions</h4>
                <div class="prose prose-sm text-gray-600 whitespace-pre-wrap bg-gray-50 p-4 rounded-xl border border-gray-100">
                    {{ $homework->description ?? 'No specific instructions provided.' }}
                </div>
            </div>
        </div>

        <!-- Submission Section -->
        <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden p-8 space-y-6">
            <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4">Your Submission</h3>
            
            @if($submission)
                <!-- View Submission -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl">
                        <span class="font-bold text-gray-700">Status</span>
                        @if($submission->status === 'graded')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-black bg-green-100 text-green-800">
                                Graded: {{ $submission->grade }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                Submitted for Grading
                            </span>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black uppercase text-purple-300 tracking-widest mb-2">Your Work</h4>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-wrap text-sm text-gray-700">
                            {{ $submission->submission_text }}
                        </div>
                    </div>
                    
                    @if($submission->status !== 'graded')
                    <!-- Form to re-submit if not graded yet -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-4">Update Submission</h4>
                        <form action="{{ route('student.homework.submit', $homework) }}" method="POST" class="space-y-4">
                            @csrf
                            <textarea name="submission_text" rows="5" required class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-white">{{ old('submission_text', $submission->submission_text) }}</textarea>
                            <button type="submit" class="w-full py-3 bg-purple-600 text-white font-bold rounded-xl shadow hover:bg-purple-700 transition-colors">
                                Resubmit Work
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @else
                <!-- New Submission Form -->
                @if(\Carbon\Carbon::parse($homework->due_date)->isPast())
                    <div class="bg-red-50 p-6 rounded-xl border border-red-100 text-center">
                        <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <h4 class="font-bold text-red-800 text-lg">Past Due</h4>
                        <p class="text-red-600 mt-1">This assignment is past its due date.</p>
                    </div>
                @else
                    <form action="{{ route('student.homework.submit', $homework) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Write your submission</label>
                            <textarea name="submission_text" rows="8" required placeholder="Type your answers here..." class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50"></textarea>
                            @error('submission_text') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-black text-lg rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all transform hover:-translate-y-1">
                            Submit Homework
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
</x-app-layout>
