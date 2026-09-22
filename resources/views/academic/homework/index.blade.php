<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Homework Assignments</h2>
            <p class="text-sm font-medium text-gray-500">Manage assignments for classes</p>
        </div>
        <a href="{{ route('academic.homework.create') }}" class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-purple-600 text-white font-bold rounded-xl shadow hover:bg-purple-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Assign Homework
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
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Class & Subject</th>
                        <th class="px-6 py-4">Due Date</th>
                        <th class="px-6 py-4 text-center">Submissions</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($homeworks as $hw)
                    <tr class="hover:bg-purple-50/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $hw->title }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="font-bold">{{ $hw->schoolClass->name }}</span>
                            <div class="text-xs text-gray-500">{{ $hw->subject->name }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold {{ \Carbon\Carbon::parse($hw->due_date)->isPast() ? 'text-red-500' : 'text-purple-600' }}">
                            {{ \Carbon\Carbon::parse($hw->due_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                {{ $hw->submissions_count }} Submitted
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('academic.homework.show', $hw) }}" class="text-indigo-600 hover:text-indigo-900 font-bold p-2 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">View</a>
                            <form action="{{ route('academic.homework.destroy', $hw) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this assignment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
                            </form>
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
