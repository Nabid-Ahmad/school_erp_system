<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span>{{ __('School Reports Directory') }}</span>
                </h2>
                <p class="text-xs font-semibold text-slate-500 mt-1">Categorized Institutional Financial, Academic, Student & HR Reports</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ search: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Search Bar Filter -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="search" placeholder="Search report by name (e.g. Cash Flow, Dues, Attendance, Results, Payroll)..." 
                       class="w-full text-sm font-semibold border-none focus:ring-0 text-slate-800 placeholder-slate-400">
            </div>

            <!-- Categorized Reports Grid matching Software Demo -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Category 1: Academic & Student Reports -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden"
                     x-show="search === '' || 'student dues class attendance exam results promotion'.includes(search.toLowerCase())">
                    <div class="bg-emerald-700/10 border-b border-emerald-700/20 px-5 py-3.5 flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        <h3 class="text-sm font-black uppercase text-emerald-900 tracking-wider">Student & Academic Reports</h3>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                        <a href="{{ route('reports.student-dues') }}" target="_blank" class="flex items-center justify-between px-5 py-3.5 hover:bg-emerald-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Customer / Student Due Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-emerald-700">➔</span>
                        </a>

                        <a href="{{ route('reports.attendance') }}" target="_blank" class="flex items-center justify-between px-5 py-3.5 hover:bg-emerald-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <span>Daily Attendance Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-emerald-700">➔</span>
                        </a>

                        <a href="{{ route('reports.results') }}" target="_blank" class="flex items-center justify-between px-5 py-3.5 hover:bg-emerald-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                <span>Exam Results & Tabulation Sheet</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-emerald-700">➔</span>
                        </a>

                        <a href="{{ route('students.index') }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-emerald-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span>Class Wise Student List Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-emerald-700">➔</span>
                        </a>
                    </div>
                </div>

                <!-- Category 2: Financial & Cash Flow Reports -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden"
                     x-show="search === '' || 'cash flow income expense ledger fees profit'.includes(search.toLowerCase())">
                    <div class="bg-purple-700/10 border-b border-purple-700/20 px-5 py-3.5 flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <h3 class="text-sm font-black uppercase text-purple-900 tracking-wider">Financial & Cash Flow Reports</h3>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                        <a href="{{ route('reports.financial') }}" target="_blank" class="flex items-center justify-between px-5 py-3.5 hover:bg-purple-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                                <span>Cash Flow Statement Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-purple-700">➔</span>
                        </a>

                        <a href="{{ route('accounts.index') }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-purple-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 00-2 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                <span>Income Expense Ledger Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-purple-700">➔</span>
                        </a>

                        <a href="{{ route('fees.index') }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-purple-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Daily Fee Collection Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-purple-700">➔</span>
                        </a>

                        <a href="{{ route('expenses.index') }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-purple-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>School Operational Expense Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-purple-700">➔</span>
                        </a>
                    </div>
                </div>

                <!-- Category 3: HR & Payroll Reports -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden"
                     x-show="search === '' || 'payroll salary teacher staff hr'.includes(search.toLowerCase())">
                    <div class="bg-blue-700/10 border-b border-blue-700/20 px-5 py-3.5 flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <h3 class="text-sm font-black uppercase text-blue-900 tracking-wider">HR & Payroll Reports</h3>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                        <a href="{{ route('reports.payroll') }}" target="_blank" class="flex items-center justify-between px-5 py-3.5 hover:bg-blue-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Staff Salary Disbursement Report</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-blue-700">➔</span>
                        </a>

                        <a href="{{ route('teachers.index') }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-blue-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>Teacher Profile & Subject Assignment</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-blue-700">➔</span>
                        </a>

                        <a href="{{ route('events.index') }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-blue-50/60 transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Academic Calendar & Events List</span>
                            </div>
                            <span class="text-slate-400 group-hover:text-blue-700">➔</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
