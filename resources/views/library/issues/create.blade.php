<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-black text-gray-900 mb-6 drop-shadow-sm">Issue Book to Student</h1>
            
            <div class="bg-white/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('library.issues.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Select Book</label>
                                <select name="book_id" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                                    <option value="">Choose a book...</option>
                                    @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} available)</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Select Student</label>
                                <select name="student_id" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                                    <option value="">Choose a student...</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user?->name ?? 'Unknown Student' }} (Roll: {{ $student->roll_no }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Issue Date</label>
                                <input type="date" name="issue_date" value="{{ date('Y-m-d') }}" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Due Date</label>
                                <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+14 days')) }}" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-600 text-white font-black py-3 px-8 rounded-xl shadow-lg hover:shadow-orange-500/30 hover:-translate-y-1 transition-all">Issue Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
