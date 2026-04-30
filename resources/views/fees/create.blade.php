<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('fees.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Collect New Fee') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('fees.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="mb-4">
                                <label for="roll_search" class="block text-sm font-bold text-gray-700">Enter Student Roll</label>
                                <input type="text" id="roll_search" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-primary p-3" placeholder="e.g. S101" value="{{ request('roll') }}">
                                <p id="search_status" class="text-xs mt-1 text-gray-400">Type roll and wait...</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700">Student Name</label>
                                <input type="text" id="student_name_display" class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-50 p-3 font-bold text-primary" readonly placeholder="Student name will appear here">
                                <input type="hidden" name="student_id" id="student_id">
                                @error('student_id')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="dues_box" class="hidden mb-6 p-4 bg-orange-50 border border-orange-200 rounded-2xl">
                            <h4 class="text-orange-700 font-black text-sm mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                Dues Found:
                            </h4>
                            <div id="dues_list" class="text-xs text-orange-600 font-bold space-y-1"></div>
                            <div class="mt-3 pt-2 border-t border-orange-200 text-orange-800 font-black">
                                Total Due: ৳<span id="total_due_display">0</span>
                            </div>
                        </div>

                        <script>
                            let currentStudentFees = {};

                            document.getElementById('roll_search').addEventListener('input', function() {
                                let roll = this.value;
                                let status = document.getElementById('search_status');
                                let nameDisplay = document.getElementById('student_name_display');
                                let studentIdInput = document.getElementById('student_id');
                                let duesBox = document.getElementById('dues_box');
                                let duesList = document.getElementById('dues_list');
                                let totalDueDisplay = document.getElementById('total_due_display');
                                let amountInput = document.getElementById('amount');
                                let feeTypeSelect = document.getElementById('fee_type');

                                if (roll.length > 0) {
                                    status.innerText = 'Searching...';
                                    fetch(`/api/students/find/${roll}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data && data.name) {
                                                nameDisplay.value = data.name;
                                                studentIdInput.value = data.id;
                                                status.innerText = '✅ Student Found!';
                                                status.classList.remove('text-gray-400', 'text-red-500');
                                                status.classList.add('text-green-500');

                                                currentStudentFees = data.class_structure || {};
                                                
                                                // Auto-fill amount for current fee type
                                                if (currentStudentFees[feeTypeSelect.value]) {
                                                    amountInput.value = currentStudentFees[feeTypeSelect.value];
                                                }

                                                // Show Dues with individual amounts
                                                if (data.dues && data.dues.length > 0) {
                                                    duesBox.classList.remove('hidden');
                                                    duesList.innerHTML = data.dues.map(d => `
                                                        <div class="flex justify-between">
                                                            <span>• ${d.label}</span>
                                                            <span>৳${d.amount}</span>
                                                        </div>
                                                    `).join('');
                                                    totalDueDisplay.innerText = data.total_due;
                                                } else {
                                                    duesBox.classList.add('hidden');
                                                }
                                            } else {
                                                nameDisplay.value = '';
                                                studentIdInput.value = '';
                                                status.innerText = '❌ Not Found';
                                                status.classList.remove('text-gray-400', 'text-green-500');
                                                status.classList.add('text-red-500');
                                                duesBox.classList.add('hidden');
                                                currentStudentFees = {};
                                            }
                                        })
                                        .catch(err => {
                                            console.error(err);
                                            status.innerText = 'Error searching';
                                            duesBox.classList.add('hidden');
                                        });
                                } else {
                                    nameDisplay.value = '';
                                    studentIdInput.value = '';
                                    status.innerText = 'Type roll and wait...';
                                    status.classList.add('text-gray-400');
                                    duesBox.classList.add('hidden');
                                    currentStudentFees = {};
                                }
                            });

                            // Auto-update amount when fee type changes
                            document.getElementById('fee_type').addEventListener('change', function() {
                                let amountInput = document.getElementById('amount');
                                if (currentStudentFees[this.value]) {
                                    amountInput.value = currentStudentFees[this.value];
                                } else {
                                    amountInput.value = '';
                                }
                            });
                        </script>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (৳)</label>
                                <input type="number" step="0.01" name="amount" id="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('amount', request('amount')) }}" required placeholder="e.g. 500">
                                @error('amount')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="fee_type" class="block text-sm font-medium text-gray-700">Fee Type</label>
                                <select name="fee_type" id="fee_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required>
                                    <option value="Monthly Fee" {{ request('type') == 'Monthly Fee' ? 'selected' : '' }}>Monthly Fee</option>
                                    <option value="Admission Fee" {{ request('type') == 'Admission Fee' ? 'selected' : '' }}>Admission Fee</option>
                                    <option value="Exam Fee">Exam Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('fee_type')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                                <select name="month" id="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required>
                                    @php
                                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                        $currentMonth = request('month', date('F'));
                                    @endphp
                                    @foreach($months as $m)
                                        <option value="{{ $m }}" {{ old('month', $currentMonth) == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                                @error('month')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                                <input type="number" name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('year', date('Y')) }}" required>
                                @error('year')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                            @error('status')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Save Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
