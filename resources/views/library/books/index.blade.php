<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-black text-gray-900 drop-shadow-sm">Library Books</h1>
                <a href="{{ route('library.books.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all">Add New Book</a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm">
                <p class="font-bold">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 font-black">Title</th>
                                    <th class="px-6 py-4 font-black">Author</th>
                                    <th class="px-6 py-4 font-black text-center">ISBN</th>
                                    <th class="px-6 py-4 font-black text-center">Total</th>
                                    <th class="px-6 py-4 font-black text-center">Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                <tr class="bg-white border-b hover:bg-purple-50/30 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $book->title }}</td>
                                    <td class="px-6 py-4">{{ $book->author }}</td>
                                    <td class="px-6 py-4 text-center text-gray-500">{{ $book->isbn ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center font-bold">{{ $book->total_copies }}</td>
                                    <td class="px-6 py-4 text-center font-black {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $book->available_copies }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-bold">No books found in the library.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
