<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-purple-600/10 text-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <span>{{ __('Accounts & Financial Ledger') }}</span>
                </h2>
                <p class="text-xs font-semibold text-slate-500 mt-1">Real-time Income, Expense, Payroll & Net Cash Flow Analysis</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('accounts.report', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" target="_blank"
                   class="bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-lg shadow-slate-900/20 transition-all hover:scale-[1.02]">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Print P&L Statement</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Filter Bar -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
                <form method="GET" action="{{ route('accounts.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Select Month</label>
                        <select name="month" class="w-full rounded-xl border-slate-300 font-bold text-sm bg-slate-50 focus:bg-white">
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Select Year</label>
                        <select name="year" class="w-full rounded-xl border-slate-300 font-bold text-sm bg-slate-50 focus:bg-white">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Ledger Filter</label>
                        <select name="type" class="w-full rounded-xl border-slate-300 font-bold text-sm bg-slate-50 focus:bg-white">
                            <option value="all" {{ $selectedType == 'all' ? 'selected' : '' }}>All Transactions</option>
                            <option value="income" {{ $selectedType == 'income' ? 'selected' : '' }}>Incomes Only (Fees)</option>
                            <option value="expense" {{ $selectedType == 'expense' ? 'selected' : '' }}>Expenses & Payroll Only</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm shadow-md transition-all">
                            Filter Ledger
                        </button>
                    </div>
                </form>
            </div>

            <!-- Financial Stat Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Income Card -->
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-3xl p-6 shadow-xl shadow-emerald-500/15 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14.93V18h-2v-1.07A4.002 4.002 0 018 13h2a2 2 0 004 0c0-1.1-.9-2-2-2s-4-.9-4-3a4.002 4.002 0 013-3.93V3h2v1.07A4.002 4.002 0 0116 8h-2a2 2 0 00-4 0c0 1.1.9 2 2 2s4 .9 4 3a4.002 4.002 0 01-3 3.93z"/></svg>
                    </div>
                    <p class="text-xs uppercase font-extrabold tracking-widest text-emerald-100 mb-1">Total Fees Income</p>
                    <h3 class="text-3xl font-black tracking-tight">৳{{ number_format($totalIncome, 2) }}</h3>
                    <div class="mt-4 pt-3 border-t border-emerald-400/30 flex justify-between items-center text-xs">
                        <span class="text-emerald-100 font-semibold">{{ $selectedMonth }} {{ $selectedYear }}</span>
                        <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md">Yearly: ৳{{ number_format($yearlyIncome, 0) }}</span>
                    </div>
                </div>

                <!-- Total Expenses Card -->
                <div class="bg-gradient-to-br from-rose-500 to-pink-600 text-white rounded-3xl p-6 shadow-xl shadow-rose-500/15 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                    <p class="text-xs uppercase font-extrabold tracking-widest text-rose-100 mb-1">School Expenses</p>
                    <h3 class="text-3xl font-black tracking-tight">৳{{ number_format($totalExpenses, 2) }}</h3>
                    <div class="mt-4 pt-3 border-t border-rose-400/30 flex justify-between items-center text-xs">
                        <span class="text-rose-100 font-semibold">Operational Costs</span>
                        <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md">Salary: ৳{{ number_format($totalSalaries, 0) }}</span>
                    </div>
                </div>

                <!-- Total Payroll Card -->
                <div class="bg-gradient-to-br from-purple-600 to-indigo-700 text-white rounded-3xl p-6 shadow-xl shadow-purple-600/15 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p class="text-xs uppercase font-extrabold tracking-widest text-purple-200 mb-1">Total Outflow (Cost + Salary)</p>
                    <h3 class="text-3xl font-black tracking-tight">৳{{ number_format($totalCombinedExpenses, 2) }}</h3>
                    <div class="mt-4 pt-3 border-t border-purple-400/30 flex justify-between items-center text-xs">
                        <span class="text-purple-200 font-semibold">All Outflow</span>
                        <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md">Yearly: ৳{{ number_format($yearlyCombinedExpenses, 0) }}</span>
                    </div>
                </div>

                <!-- Net Cash Balance Card -->
                <div class="bg-gradient-to-br {{ $netBalance >= 0 ? 'from-blue-600 to-indigo-800' : 'from-amber-600 to-orange-700' }} text-white rounded-3xl p-6 shadow-xl shadow-blue-600/15 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-xs uppercase font-extrabold tracking-widest text-blue-200 mb-1">Net Balance (Profit / Loss)</p>
                    <h3 class="text-3xl font-black tracking-tight">৳{{ number_format($netBalance, 2) }}</h3>
                    <div class="mt-4 pt-3 border-t border-blue-400/30 flex justify-between items-center text-xs">
                        <span class="font-bold uppercase tracking-wider {{ $netBalance >= 0 ? 'text-emerald-300' : 'text-amber-300' }}">
                            {{ $netBalance >= 0 ? 'Surplus / Profit' : 'Deficit / Loss' }}
                        </span>
                        <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md">Yearly Net: ৳{{ number_format($yearlyNetBalance, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Financial Ledger Table Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Unified Financial Transactions Ledger</h3>
                        <p class="text-xs font-semibold text-slate-500">All registered inflows and outflows for {{ $selectedMonth }} {{ $selectedYear }}</p>
                    </div>
                    <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-extrabold border border-purple-100">
                        {{ $ledger->count() }} Transactions Found
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] font-black uppercase text-slate-500 tracking-wider border-b border-slate-100">
                                <th class="py-4 px-6">Date & Ref</th>
                                <th class="py-4 px-6">Type</th>
                                <th class="py-4 px-6">Category / Title</th>
                                <th class="py-4 px-6">Party / Person</th>
                                <th class="py-4 px-6 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-semibold text-slate-700">
                            @forelse($ledger as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="font-bold text-slate-900">{{ $item['date']->format('d M, Y') }}</div>
                                        <div class="text-xs text-slate-400 font-mono">{{ $item['reference'] }}</div>
                                    </td>

                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @if($item['type'] === 'income')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                                INFLOW (INCOME)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-rose-50 text-rose-700 border border-rose-200/60">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                                OUTFLOW (EXPENSE)
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6">
                                        <div class="font-extrabold text-slate-800">{{ $item['title'] }}</div>
                                        <div class="text-xs text-slate-500 font-medium">{{ $item['category'] }}</div>
                                    </td>

                                    <td class="py-4 px-6 whitespace-nowrap font-bold text-slate-700">
                                        {{ $item['payer_payee'] }}
                                    </td>

                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        @if($item['type'] === 'income')
                                            <span class="text-emerald-600 font-black text-base">+ ৳{{ number_format($item['amount'], 2) }}</span>
                                        @else
                                            <span class="text-rose-600 font-black text-base">- ৳{{ number_format($item['amount'], 2) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400 font-semibold">
                                        No financial transactions found for {{ $selectedMonth }} {{ $selectedYear }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
