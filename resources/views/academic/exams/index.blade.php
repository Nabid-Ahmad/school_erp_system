<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Examinations</h2>
            <p class="text-sm font-medium text-gray-500">Manage school exams and terms</p>
        </div>
        <a href="{{ route('exams.create') }}" class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-purple-600 text-white font-bold rounded-xl shadow hover:bg-purple-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New Exam
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Exam Name</th>
                        <th class="px-6 py-4">Date Range</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($exams as $exam)
                    @php
                        $now = \Carbon\Carbon::now();
                        $start = \Carbon\Carbon::parse($exam->start_date);
                        $end = \Carbon\Carbon::parse($exam->end_date);
                        $isUpcoming = $now->lt($start);
                        $isOngoing = $now->between($start, $end->endOfDay());
                        $isCompleted = $now->gt($end->endOfDay());
                    @endphp
                    <tr class="hover:bg-purple-50/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $exam->name }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $start->format('M d, Y') }} - {{ $end->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($isUpcoming)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Upcoming</span>
                            @elseif($isOngoing)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ongoing</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Completed</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('exams.edit', $exam) }}" class="text-indigo-600 hover:text-indigo-900 font-bold p-2 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">Edit</a>
                            <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this exam? Results associated might be affected.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 font-medium italic">
                            No exams found. Add a new exam.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $exams->links() }}
        </div>
    </div>
</div>
</x-app-layout>
