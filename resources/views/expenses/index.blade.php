<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Expense Management') }}
            </h2>
            <a href="{{ route('expenses.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg font-bold text-sm hover:opacity-90 transition">
                + Add Expense
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Total Expenses</p>
                    <p class="text-3xl font-black text-red-600">৳{{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-4 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Date</th>
                                <th class="px-4 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Title</th>
                                <th class="px-4 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Category</th>
                                <th class="px-4 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                <th class="px-4 py-3 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-4 text-sm text-gray-500 font-bold">{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</td>
                                <td class="px-4 py-4 font-bold text-gray-800">{{ $expense->title }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                                        {{ $expense->category }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 font-black text-red-600">৳{{ number_format($expense->amount, 2) }}</td>
                                <td class="px-4 py-4 text-right flex justify-end gap-2">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-500 hover:text-blue-700 p-2 bg-blue-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-2 bg-red-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
