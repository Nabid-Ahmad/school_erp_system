<x-app-layout>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Apply for Leave</h2>
            <p class="text-sm font-medium text-gray-500">Submit a new leave request</p>
        </div>
        <a href="{{ route('hr.leaves.index') }}" class="px-4 py-2 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
            Back
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <form action="{{ route('hr.leaves.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Leave Type</label>
                <select name="leave_type" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                    <option value="">Select leave type</option>
                    <option value="sick">Sick Leave</option>
                    <option value="casual">Casual Leave</option>
                    <option value="maternity">Maternity Leave</option>
                    <option value="other">Other</option>
                </select>
                @error('leave_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Start Date</label>
                    <input type="date" name="start_date" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                    @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">End Date</label>
                    <input type="date" name="end_date" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50">
                    @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase tracking-wide">Reason</label>
                <textarea name="reason" rows="4" required class="mt-2 block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-gray-50" placeholder="Please explain why you need this leave..."></textarea>
                @error('reason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-black text-lg rounded-xl shadow-lg hover:from-amber-600 hover:to-amber-700 transition-all transform hover:-translate-y-1">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
