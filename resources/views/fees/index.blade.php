<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Fee Records') }}
            </h2>
            <a href="{{ route('fees.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Collect Fee
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl relative mb-6 flex justify-between items-center" role="alert">
                    <div>
                        <strong class="font-black uppercase tracking-widest text-xs">Success!</strong>
                        <span class="block sm:inline ml-2 font-bold">{{ session('success') }}</span>
                    </div>
                    @if(session('print_id'))
                        <a href="{{ route('fees.receipt', session('print_id')) }}" class="bg-deep-green text-white px-4 py-2 rounded-xl font-black text-sm flex items-center gap-2 shadow-lg hover:scale-105 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4m14 0h-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v4"></path></svg>
                            Download Receipt
                        </a>
                    @endif
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="px-4 py-3 border-b">Roll</th>
                                <th class="px-4 py-3 border-b">Student</th>
                                <th class="px-4 py-3 border-b">Type</th>
                                <th class="px-4 py-3 border-b">Class</th>
                                <th class="px-4 py-3 border-b">Month</th>
                                <th class="px-4 py-3 border-b">Year</th>
                                <th class="px-4 py-3 border-b">Amount</th>
                                <th class="px-4 py-3 border-b">Status</th>
                                <th class="px-4 py-3 border-b text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fees as $fee)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-3">{{ $fee->student->roll }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $fee->student->name }}</td>
                                    <td class="px-4 py-3"><span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full font-bold">{{ $fee->fee_type }}</span></td>
                                    <td class="px-4 py-3 text-sm">Class {{ $fee->student->schoolClass->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $fee->month }}</td>
                                    <td class="px-4 py-3">{{ $fee->year }}</td>
                                    <td class="px-4 py-3 font-bold">৳{{ number_format($fee->amount, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $fee->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ strtoupper($fee->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('fees.receipt', $fee) }}" class="text-green-600 hover:text-green-800 font-bold text-sm bg-green-50 px-3 py-1 rounded-lg mr-2 inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v4"></path></svg>
                                            Receipt
                                        </a>
                                        <a href="{{ route('fees.edit', $fee) }}" class="text-primary hover:underline mr-3">Edit</a>
                                        <form action="{{ route('fees.destroy', $fee) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $fees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
