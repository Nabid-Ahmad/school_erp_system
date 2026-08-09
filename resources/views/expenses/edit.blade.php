<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('expenses.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Expense') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('expenses.update', $expense) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Expense Title</label>
                            <input type="text" name="title" placeholder="Ex: Electricity Bill" value="{{ old('title', $expense->title) }}" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold @error('title') ring-2 ring-red-400 @enderror" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Amount (৳)</label>
                                <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense->amount) }}" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold @error('amount') ring-2 ring-red-400 @enderror" required>
                                @error('amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Date</label>
                                <input type="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($expense->date)->format('Y-m-d')) }}" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold @error('date') ring-2 ring-red-400 @enderror" required>
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                            <select name="category" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold">
                                @php
                                    $categories = ['Utilities', 'Salary', 'Supplies', 'Maintenance', 'Entertainment', 'Other'];
                                @endphp
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" @selected(old('category', $expense->category) === $cat)>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Description (Optional)</label>
                            <textarea name="description" rows="3" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-red-500 font-bold" placeholder="Additional notes...">{{ old('description', $expense->description) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('expenses.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                            <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-red-200 hover:opacity-90 transition">Update Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
