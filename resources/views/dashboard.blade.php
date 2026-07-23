<x-app-layout>
    <div class="py-12 min-h-screen relative overflow-hidden" style="background: url('/images/water_bg.png') center center fixed; background-size: cover;">
        <!-- Subtle Overlay for Readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-emerald-900/90 to-teal-900/95 backdrop-blur-sm"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <!-- School Header Banner -->
            <div class="relative mb-10 overflow-hidden rounded-[2.5rem] bg-gradient-to-r from-green-700 to-green-500 p-10 text-white shadow-2xl">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <h1 class="text-4xl font-black mb-2 drop-shadow-md">Welcome, {{ Auth::user()->name }}!</h1>
                        <p class="text-green-50 text-lg font-bold drop-shadow-sm">Bangla Model School Management Dashboard</p>
                        <div class="mt-6 flex gap-4">
                            <span class="px-4 py-2 bg-white/20 backdrop-blur rounded-xl text-xs font-black border border-white/20 uppercase tracking-widest shadow-sm">
                                {{ now()->format('l, d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex -space-x-4">
                        <div class="w-16 h-16 rounded-full border-4 border-white bg-green-400 flex items-center justify-center text-white shadow-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="w-16 h-16 rounded-full border-4 border-white bg-blue-400 flex items-center justify-center text-white shadow-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div class="w-16 h-16 rounded-full border-4 border-white bg-orange-400 flex items-center justify-center font-bold text-xl text-white shadow-xl">+</div>
                    </div>
                </div>
                <!-- Abstract Design Background -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl shadow-md border-l-8 border-green-500 hover:shadow-xl transition-all group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Students</div>
                    <div class="text-3xl font-black text-gray-800">{{ number_format($totalStudents) }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-md border-l-8 border-blue-500 hover:shadow-xl transition-all group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Teachers</div>
                    <div class="text-3xl font-black text-gray-800">{{ number_format($totalTeachers) }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-md border-l-8 border-orange-500 hover:shadow-xl transition-all group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Present Today</div>
                    <div class="text-3xl font-black text-gray-800">{{ number_format($todayAttendance) }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-md border-l-8 border-red-500 hover:shadow-xl transition-all group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Monthly Income</div>
                    <div class="text-3xl font-black text-gray-800">৳{{ number_format($monthlyFees) }}</div>
                </div>
            </div>

            <!-- Financial Summary & Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-10">
                <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-md border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                            <span class="w-2 h-8 bg-green-600 rounded-full"></span>
                            Financial Overview
                        </h2>
                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Live Statistics</span>
                    </div>
                    <div class="h-64">
                        <canvas id="financialChart"></canvas>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-green-700 to-green-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-green-200 relative overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-90 mb-2 drop-shadow-sm">Monthly Net Profit</p>
                        <h3 class="text-4xl font-black italic tracking-tight drop-shadow-md">৳{{ number_format($monthlyFees - $totalExpenses, 2) }}</h3>
                        <div class="mt-6 pt-6 border-t border-white/20 flex justify-between items-end">
                            <div>
                                <p class="text-[10px] font-bold uppercase opacity-80 drop-shadow-sm">Revenue</p>
                                <p class="text-lg font-black drop-shadow-sm">৳{{ number_format($monthlyFees, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold uppercase opacity-80 drop-shadow-sm">Expenses</p>
                                <p class="text-lg font-black text-red-200 drop-shadow-sm">৳{{ number_format($totalExpenses, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-[2rem] shadow-md border border-gray-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Status</p>
                            <p class="text-lg font-black text-gray-900 italic">Growing School</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-2xl font-black text-gray-900 flex items-center gap-3 bg-white/50 backdrop-blur-md px-4 py-2 rounded-2xl inline-flex">
                        <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                        Quick Operations
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <a href="{{ route('students.create') }}" class="group bg-white p-6 rounded-3xl shadow-md hover:bg-green-600 transition-all flex items-center gap-5 border border-gray-100 hover:shadow-xl">
                            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-white/20 group-hover:text-white transition shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <div>
                                <div class="font-black text-gray-900 group-hover:text-white transition">Add Student</div>
                                <div class="text-xs text-gray-400 group-hover:text-green-100 transition uppercase font-black">Registration</div>
                            </div>
                        </a>
                        <a href="{{ route('fees.create') }}" class="group bg-white p-6 rounded-3xl shadow-md hover:bg-orange-600 transition-all flex items-center gap-5 border border-gray-100 hover:shadow-xl">
                            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 group-hover:bg-white/20 group-hover:text-white transition shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-black text-gray-900 group-hover:text-white transition">Collect Fees</div>
                                <div class="text-xs text-gray-400 group-hover:text-orange-100 transition uppercase font-black">Finance</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="space-y-6">
                    <h2 class="text-2xl font-black text-gray-900 bg-white/50 backdrop-blur-md px-4 py-2 rounded-2xl inline-flex">Latest News</h2>
                    <div class="bg-white p-8 rounded-[2rem] shadow-md border border-gray-100">
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-2 h-2 mt-2 bg-green-500 rounded-full"></div>
                                <p class="text-sm font-bold text-gray-800">Annual Exam results are out!</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-2 h-2 mt-2 bg-blue-500 rounded-full"></div>
                                <p class="text-sm font-bold text-gray-800">New batch admissions started.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financialChart').getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Income', 'Expenses'],
                        datasets: [{
                            label: '৳',
                            data: [{{ $monthlyFees }}, {{ $totalExpenses }}],
                            backgroundColor: ['#15803d', '#ef4444'],
                            borderRadius: 15,
                            barThickness: 50
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [4, 4], drawBorder: false } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
