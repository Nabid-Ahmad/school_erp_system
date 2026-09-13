<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-black text-gray-900 drop-shadow-sm">Issued Books</h1>
                <a href="{{ route('library.issues.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all">Issue New Book</a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm">
                <p class="font-bold">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm">
                <p class="font-bold">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 font-black">Student</th>
                                    <th class="px-6 py-4 font-black">Book Title</th>
                                    <th class="px-6 py-4 font-black text-center">Issue Date</th>
                                    <th class="px-6 py-4 font-black text-center">Due Date</th>
                                    <th class="px-6 py-4 font-black text-center">Status</th>
                                    <th class="px-6 py-4 font-black text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($issues as $issue)
                                <tr class="bg-white border-b hover:bg-amber-50/30 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $issue->student->user?->name ?? 'Unknown Student' }} <br><span class="text-xs text-gray-400">Roll: {{ $issue->student->roll_no }}</span></td>
                                    <td class="px-6 py-4 font-bold">{{ $issue->book->title }}</td>
                                    <td class="px-6 py-4 text-center">{{ $issue->issue_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-center {{ $issue->due_date->isPast() && $issue->status === 'issued' ? 'text-red-500 font-bold' : '' }}">{{ $issue->due_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($issue->status === 'issued')
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-black uppercase">Issued</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-black uppercase">Returned</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($issue->status === 'issued')
                                        <form action="{{ route('library.issues.return', $issue->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-black text-purple-600 hover:text-purple-900 bg-purple-50 hover:bg-purple-100 px-3 py-1 rounded-lg transition-colors">Mark Returned</button>
                                        </form>
                                        @else
                                        <span class="text-xs font-bold text-gray-400">{{ $issue->return_date->format('d M Y') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 font-bold">No books have been issued yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $issues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
