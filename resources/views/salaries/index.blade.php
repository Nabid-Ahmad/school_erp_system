<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Payroll') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Compact Payment Form with Search -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-green-500 rounded-full"></span>
                    Process Payment
                </h3>
                
                <form action="{{ route('salaries.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Search Teacher (Name or ID)</label>
                            <div class="relative">
                                <select name="teacher_id" id="teacher_select" required class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary font-bold shadow-sm select2-searchable">
                                    <option value="" disabled selected>-- Search by Name or ID (e.g. T-0001) --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" data-due="{{ $teacher->total_due }}" data-salary="{{ $teacher->salary }}">
                                            [{{ $teacher->teacher_id_number }}] {{ $teacher->name }} - {{ $teacher->designation }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="bg-orange-50 p-3 rounded-xl border border-orange-100">
                            <p class="text-[9px] font-black text-orange-400 uppercase tracking-widest mb-1">Previous Due</p>
                            <p class="text-xl font-black text-orange-600" id="due_display">৳0</p>
                        </div>

                        <div class="bg-green-50 p-3 rounded-xl border border-green-100">
                            <p class="text-[9px] font-black text-green-400 uppercase tracking-widest mb-1">Monthly Salary</p>
                            <p class="text-xl font-black text-green-600" id="salary_display">৳0</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Month & Year</label>
                            <div class="flex gap-2">
                                <select name="month" class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary font-bold shadow-sm text-sm">
                                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                                        <option value="{{ $m }}" {{ $m == now()->format('F') ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="year" value="{{ date('Y') }}" class="w-20 bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary font-bold shadow-sm text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Amount to Pay (৳)</label>
                            <input type="number" name="amount" id="amount_input" required step="0.01" class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary font-black text-lg shadow-sm text-green-600">
                        </div>
                        <div class="col-span-1 md:col-span-2 flex gap-3">
                            <div class="flex-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Note (Optional)</label>
                                <input type="text" name="note" class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary font-bold shadow-sm" placeholder="Any remark...">
                            </div>
                            <button type="submit" class="self-end bg-primary text-white px-6 py-3 rounded-xl font-black shadow-lg shadow-primary/20 hover:scale-105 transition-all text-sm whitespace-nowrap">
                                Pay Salary
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Compact Payment History -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <h3 class="text-lg font-black text-gray-800 mb-6">Payment History</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-3 pl-2">Teacher</th>
                                <th class="pb-3">Month/Year</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Date</th>
                                <th class="pb-3 text-right pr-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($salaries as $salary)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 pl-2">
                                        <p class="font-black text-gray-800 text-sm">{{ $salary->teacher->name }}</p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">ID: {{ $salary->teacher->teacher_id_number }} | {{ $salary->teacher->designation }}</p>
                                    </td>
                                    <td class="py-4">
                                        <span class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-bold text-gray-600">{{ $salary->month }} {{ $salary->year }}</span>
                                    </td>
                                    <td class="py-4 font-black text-green-600">৳{{ number_format($salary->amount, 2) }}</td>
                                    <td class="py-4 text-xs text-gray-500 font-bold">{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M, Y') }}</td>
                                    <td class="py-4 text-right pr-2">
                                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded-md text-[9px] font-black uppercase">Paid</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $salaries->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Include Search Library for Dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#teacher_select').select2({
                placeholder: "-- Search by Name or ID --",
                allowClear: true,
                width: '100%'
            });

            $('#teacher_select').on('change', function() {
                const selected = this.options[this.selectedIndex];
                const due = selected.getAttribute('data-due') || 0;
                const salary = selected.getAttribute('data-salary') || 0;
                
                document.getElementById('due_display').innerText = '৳' + new Intl.NumberFormat().format(due);
                document.getElementById('salary_display').innerText = '৳' + new Intl.NumberFormat().format(salary);
                document.getElementById('amount_input').value = salary;
            });
        });
    </script>
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #f9fafb !important;
            border: none !important;
            border-radius: 0.75rem !important;
            height: 52px !important;
            padding: 10px !important;
            font-weight: 700 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px !important;
        }
    </style>
</x-app-layout>
