<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">My Homework</h2>
            <p class="text-sm font-medium text-gray-500">View and submit your assignments</p>
        </div>
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
                        <th class="px-6 py-4">Assignment Title</th>
                        <th class="px-6 py-4">Subject & Teacher</th>
                        <th class="px-6 py-4">Due Date</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($homeworks as $hw)
                    @php
                        $submission = $hw->submissions->first();
                        $isPastDue = \Carbon\Carbon::parse($hw->due_date)->isPast();
                    @endphp
                    <tr class="hover:bg-purple-50/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $hw->title }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="font-bold">{{ $hw->subject->name }}</span>
                            <div class="text-xs text-gray-500">{{ optional($hw->teacher)->name }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold {{ $isPastDue ? 'text-red-500' : 'text-gray-900' }}">
                            {{ \Carbon\Carbon::parse($hw->due_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($submission)
                                @if($submission->status === 'graded')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Graded: {{ $submission->grade }}</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Submitted</span>
                                @endif
                            @else
                                @if($isPastDue)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Missing</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('student.homework.show', $hw) }}" class="text-purple-600 hover:text-purple-900 font-bold p-2 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                {{ $submission ? 'View Submission' : 'Submit Work' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 font-medium italic">
                            No homework assigned yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
