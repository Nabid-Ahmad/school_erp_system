<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $homework->title }}</h2>
            <p class="text-sm font-medium text-gray-500">{{ $homework->schoolClass->name }} • {{ $homework->subject->name }}</p>
        </div>
        <a href="{{ route('academic.homework.index') }}" class="px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
            Back to Assignments
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Assignment Details -->
        <div class="lg:col-span-1">
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden p-6 space-y-6">
                <div>
                    <h3 class="text-[10px] font-black uppercase text-purple-300 tracking-widest mb-1">Due Date</h3>
                    <div class="font-bold text-gray-900 {{ \Carbon\Carbon::parse($homework->due_date)->isPast() ? 'text-red-600' : '' }}">
                        {{ \Carbon\Carbon::parse($homework->due_date)->format('l, F j, Y') }}
                    </div>
                </div>
                <div>
                    <h3 class="text-[10px] font-black uppercase text-purple-300 tracking-widest mb-1">Teacher</h3>
                    <div class="font-bold text-gray-900">{{ $homework->teacher->name }}</div>
                </div>
                <div>
                    <h3 class="text-[10px] font-black uppercase text-purple-300 tracking-widest mb-2">Description</h3>
                    <div class="prose prose-sm text-gray-600 whitespace-pre-wrap">
                        {{ $homework->description ?? 'No description provided.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="lg:col-span-2">
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Student Submissions</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        {{ $homework->submissions->count() }} Received
                    </span>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($homework->submissions as $submission)
                    <div class="p-6 hover:bg-gray-50/30 transition-colors">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">{{ optional($submission->student->user)->name ?? 'Student ID: ' . $submission->student_id }}</h4>
                                <div class="text-xs text-gray-500">Submitted {{ $submission->created_at->diffForHumans() }}</div>
                            </div>
                            @if($submission->status === 'graded')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-black bg-green-100 text-green-800">
                                    Grade: {{ $submission->grade }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    Needs Grading
                                </span>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-4 whitespace-pre-wrap text-sm text-gray-700">
                            {{ $submission->submission_text }}
                        </div>

                        <!-- Grading Form -->
                        <form action="{{ route('academic.homework.submissions.grade', $submission) }}" method="POST" class="flex gap-3">
                            @csrf
                            <input type="text" name="grade" placeholder="Enter Grade (e.g. A+, 95/100)" required value="{{ $submission->grade }}" class="flex-1 rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm bg-white">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow hover:bg-indigo-700 transition-colors text-sm">
                                Save Grade
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-400 font-medium italic">
                        No submissions received yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
