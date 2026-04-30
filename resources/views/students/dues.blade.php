<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('students.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">&larr; Back</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Fee Dues Report') }}: {{ $student->name }}
                </h2>
            </div>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-xl font-black shadow-sm">
                Total Due: ৳{{ number_format($totalDueAmount, 2) }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Mini Profile -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8 flex items-center gap-8">
                @if($student->image)
                    <img src="{{ asset('storage/' . $student->image) }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 font-bold text-2xl">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-2xl font-black text-gray-800">{{ $student->name }}</h3>
                    <p class="text-gray-400 font-bold">Roll: {{ $student->roll }} | Class: {{ $student->schoolClass->name ?? 'N/A' }}</p>
                    <div class="mt-2 flex gap-4 text-sm font-bold">
                        <span class="text-green-600">Monthly Fee: ৳{{ number_format($student->schoolClass->monthly_fee ?? 0, 2) }}</span>
                        <span class="text-blue-600">Admission Fee: ৳{{ number_format($student->schoolClass->admission_fee ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Dues List -->
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="p-8">
                    <h4 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-red-500 rounded-full"></span>
                        Pending Payments
                    </h4>
                    
                    <div class="space-y-4">
                        @forelse($dues as $due)
                            <div class="flex items-center justify-between p-6 bg-red-50 rounded-2xl border border-red-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-red-500 shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-black text-gray-800">{{ $due['type'] }}</div>
                                        <div class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $due['month'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-black text-red-600">৳{{ number_format($due['amount'], 2) }}</div>
                                    <a href="{{ route('fees.create') }}?roll={{ $student->roll }}&month={{ $due['month'] }}&type={{ $due['type'] }}&amount={{ $due['amount'] }}" class="text-xs font-bold text-blue-600 hover:underline">Pay Now &rarr;</a>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-green-500 mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h5 class="text-xl font-black text-gray-800">No Dues!</h5>
                                <p class="text-gray-400">All fees are up to date for this student.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Payment History Mini Table -->
            <div class="mt-10">
                <h4 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-green-500 rounded-full"></span>
                    Recent Payments
                </h4>
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-widest">
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Month</th>
                                <th class="px-6 py-4 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($student->fees->where('status', 'paid')->sortByDesc('created_at')->take(5) as $fee)
                                <tr class="text-sm">
                                    <td class="px-6 py-4 text-gray-500">{{ $fee->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $fee->fee_type }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $fee->month }}</td>
                                    <td class="px-6 py-4 text-right font-black text-green-600">৳{{ number_format($fee->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
