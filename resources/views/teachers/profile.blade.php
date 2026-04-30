<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teacher Profile') }}
            </h2>
            <a href="{{ route('teachers.id-card', $teacher->id) }}" target="_blank" class="bg-deep-green text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-green-900/20 hover:scale-105 transition-all text-sm">
                Generate ID Card
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Header -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full blur-3xl -mr-32 -mt-32"></div>
                
                <div class="flex flex-col md:flex-row items-center gap-10 relative z-10">
                    <div class="w-48 h-48 rounded-[2.5rem] overflow-hidden border-8 border-gray-50 shadow-xl">
                        @if($teacher->image)
                            <img src="{{ asset('storage/'.$teacher->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-deep-green flex items-center justify-center text-white text-6xl font-black">
                                {{ substr($teacher->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-black text-gray-800 mb-2">{{ $teacher->name }}</h1>
                        <p class="text-lg font-bold text-green-600 mb-6 uppercase tracking-widest">{{ $teacher->designation ?? 'Senior Teacher' }}</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Subject</p>
                                <p class="font-bold text-gray-700">{{ $teacher->subject }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Phone</p>
                                <p class="font-bold text-gray-700">{{ $teacher->phone }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Monthly Salary</p>
                                <p class="font-bold text-gray-700">৳{{ number_format($teacher->salary) }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Joined</p>
                                <p class="font-bold text-gray-700">{{ $teacher->joining_date ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Due Section -->
            <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-red-900/5 border border-red-50">
                <h3 class="text-xl font-black text-red-600 mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 bg-red-500 rounded-full"></span>
                    Pending / Due Salaries
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-4">Month/Year</th>
                                <th class="pb-4">Fixed Salary</th>
                                <th class="pb-4">Paid</th>
                                <th class="pb-4 text-red-500">Due / Arrears</th>
                                <th class="pb-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php $totalDue = 0; @endphp
                            @forelse($pendingSalaries as $due)
                                @php $totalDue += $due['due']; @endphp
                                <tr>
                                    <td class="py-5 font-black text-gray-800">{{ $due['month'] }} {{ $due['year'] }}</td>
                                    <td class="py-5 font-bold text-gray-500">৳{{ number_format($due['fixed_salary']) }}</td>
                                    <td class="py-5 font-bold text-green-600">৳{{ number_format($due['paid']) }}</td>
                                    <td class="py-5 font-black text-red-600">৳{{ number_format($due['due']) }}</td>
                                    <td class="py-5">
                                        <span class="px-3 py-1 {{ $due['status'] == 'Partial' ? 'bg-orange-100 text-orange-600' : 'bg-red-100 text-red-600' }} rounded-full text-[10px] font-black uppercase tracking-widest">
                                            {{ $due['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-green-500 font-bold italic">✨ All salaries are fully paid up to date!</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($totalDue > 0)
                            <tfoot>
                                <tr class="bg-red-50/50">
                                    <td colspan="3" class="p-5 text-right font-black text-gray-500 uppercase text-xs">Total Net Due:</td>
                                    <td colspan="2" class="p-5 font-black text-2xl text-red-600">৳{{ number_format($totalDue) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Salary History -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
                <h3 class="text-xl font-black text-gray-800 mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                    Salary Payment History
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-4">Month/Year</th>
                                <th class="pb-4">Amount Paid</th>
                                <th class="pb-4">Payment Date</th>
                                <th class="pb-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($salaries as $salary)
                                <tr>
                                    <td class="py-5 font-black text-gray-800">{{ $salary->month }} {{ $salary->year }}</td>
                                    <td class="py-5 font-black text-green-600">৳{{ number_format($salary->amount, 2) }}</td>
                                    <td class="py-5 text-sm text-gray-500 font-bold">{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M, Y') }}</td>
                                    <td class="py-5">
                                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest">Paid</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-400 font-bold">No payment history found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
