<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Salary Sheet - ') }} {{ $payroll->month }} {{ $payroll->year }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl mb-4 font-bold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-4 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <div class="flex justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-black text-gray-800">Salary Sheet</h3>
                        <p class="text-gray-500 font-bold">{{ $payroll->month }}, {{ $payroll->year }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 font-black uppercase tracking-widest">Total Payable</p>
                        <p class="text-2xl font-black text-green-600">৳{{ number_format($payroll->total_amount, 2) }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-500 uppercase tracking-widest bg-gray-50">
                                <th class="p-3 border border-gray-100">Staff Name</th>
                                <th class="p-3 border border-gray-100">Basic</th>
                                <th class="p-3 border border-gray-100 text-green-600">Allowance</th>
                                <th class="p-3 border border-gray-100 text-red-600">Deduction</th>
                                <th class="p-3 border border-gray-100">Net Salary</th>
                                <th class="p-3 border border-gray-100 text-center">Status</th>
                                <th class="p-3 border border-gray-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payslips as $slip)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border border-gray-100 font-bold text-gray-800">
                                        {{ $slip->teacher->name }}<br>
                                        <span class="text-xs text-gray-400">{{ $slip->teacher->designation }}</span>
                                    </td>
                                    <td class="p-3 border border-gray-100 text-gray-600 font-bold">৳{{ number_format($slip->basic_salary, 2) }}</td>
                                    <td class="p-3 border border-gray-100 text-green-600 font-bold">৳{{ number_format($slip->allowance, 2) }}</td>
                                    <td class="p-3 border border-gray-100 text-red-600 font-bold">৳{{ number_format($slip->deduction, 2) }}</td>
                                    <td class="p-3 border border-gray-100 text-purple-700 font-black">৳{{ number_format($slip->net_salary, 2) }}</td>
                                    <td class="p-3 border border-gray-100 text-center">
                                        @if($slip->status === 'paid')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-black uppercase">Paid</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-black uppercase">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="p-3 border border-gray-100 text-center">
                                        @if($slip->status !== 'paid')
                                            <form action="{{ route('payrolls.pay', $slip->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded font-bold text-xs shadow-sm transition">
                                                    Pay Now
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-bold">{{ \Carbon\Carbon::parse($slip->payment_date)->format('d M, Y') }}</span>
                                        @endif
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
