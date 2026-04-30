<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('expenses.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Expense Title</label>
                            <input type="text" name="title" placeholder="Ex: Electricity Bill" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Amount (৳)</label>
                                <input type="number" step="0.01" name="amount" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold" required>
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Date</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                            <select name="category" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold">
                                <option value="Utilities">Utilities (Electricity, Water, etc.)</option>
                                <option value="Salary">Staff Salary</option>
                                <option value="Supplies">Office Supplies</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Entertainment">Entertainment/Snacks</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Description (Optional)</label>
                            <textarea name="description" rows="3" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold" placeholder="Additional notes..."></textarea>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('expenses.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                            <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-red-200 hover:opacity-90 transition">Save Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
