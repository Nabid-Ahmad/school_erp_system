<x-app-layout>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Add Route</h2>
            <p class="text-sm font-medium text-gray-500">Define a new transport route</p>
        </div>
        <a href="{{ route('transport.routes.index') }}" class="px-4 py-2 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
            Back
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <form action="{{ route('transport.routes.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Route Name</label>
                <input type="text" name="name" required placeholder="e.g. Route A (North City)" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Start Point</label>
                    <input type="text" name="start_point" required placeholder="e.g. Central Station" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                    @error('start_point') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">End Point</label>
                    <input type="text" name="end_point" required placeholder="e.g. School Campus" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                    @error('end_point') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Monthly Fare ($)</label>
                <input type="number" step="0.01" name="fare" required placeholder="e.g. 50.00" class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                @error('fare') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-black text-lg rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all transform hover:-translate-y-1">
                    Save Route
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
