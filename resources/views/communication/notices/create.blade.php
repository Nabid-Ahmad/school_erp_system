<x-app-layout>
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Publish Notice</h2>
            <p class="text-sm font-medium text-gray-500">Create a new announcement</p>
        </div>
        <a href="{{ route('communication.notices.index') }}" class="px-4 py-2 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
            Back
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <form action="{{ route('communication.notices.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Notice Title</label>
                <input type="text" name="title" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 text-lg font-bold" placeholder="E.g., School closed due to heavy rain">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Target Audience</label>
                    <select name="target_audience" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                        <option value="all">Everyone</option>
                        <option value="teachers">Teachers Only</option>
                        <option value="students">Students Only</option>
                        <option value="parents">Parents Only</option>
                    </select>
                    @error('target_audience') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Expiry Date (Optional)</label>
                    <input type="date" name="expires_at" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <p class="text-xs text-gray-400 mt-1">Leave empty if the notice doesn't expire.</p>
                    @error('expires_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Content</label>
                <textarea name="content" rows="6" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50" placeholder="Type the full notice content here..."></textarea>
                @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-black text-lg rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all transform hover:-translate-y-1">
                    Publish Notice Now
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
