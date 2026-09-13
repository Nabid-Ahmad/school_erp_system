<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-black text-gray-900 mb-6 drop-shadow-sm">Add New Book</h1>
            
            <div class="bg-white/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('library.books.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Title</label>
                                <input type="text" name="title" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Author</label>
                                <input type="text" name="author" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">ISBN (Optional)</label>
                                <input type="text" name="isbn" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Publisher (Optional)</label>
                                <input type="text" name="publisher" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Total Copies</label>
                                <input type="number" name="total_copies" value="1" min="1" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-gradient-to-r from-purple-600 to-purple-800 text-white font-black py-3 px-8 rounded-xl shadow-lg hover:shadow-purple-500/30 hover:-translate-y-1 transition-all">Save Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
