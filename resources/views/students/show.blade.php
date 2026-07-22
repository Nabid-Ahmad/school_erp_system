<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Student Profile: {{ $student->name }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('students.id-card', $student) }}" class="bg-green-600 text-white px-4 py-2 rounded-xl font-bold text-sm hover:opacity-90 transition">
                    Download ID Card
                </a>
                <a href="{{ route('students.edit', $student) }}" class="bg-primary text-white px-4 py-2 rounded-xl font-bold text-sm hover:opacity-90 transition">
                    Edit Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Profile Header -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex flex-col md:flex-row gap-8 items-center">
                <div class="relative">
                    @if($student->image)
                        <img src="{{ filter_var($student->image, FILTER_VALIDATE_URL) ? $student->image : asset('storage/' . $student->image) }}" class="w-32 h-32 rounded-[2rem] object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-[2rem] bg-gray-100 flex items-center justify-center text-gray-400 font-black text-2xl border-4 border-white shadow-xl">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 bg-green-500 text-white p-2 rounded-xl shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                
                <div class="text-center md:text-left space-y-2">
                    <h1 class="text-3xl font-black text-gray-800 tracking-tight">{{ $student->name }}</h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <span class="px-4 py-1 bg-primary/10 text-primary rounded-full text-xs font-black uppercase tracking-widest">Class {{ $student->schoolClass->name }}</span>
                        <span class="px-4 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-black uppercase tracking-widest">Roll: {{ $student->roll }}</span>
                        <span class="px-4 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-black uppercase tracking-widest">Joined: {{ $student->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <div class="md:ml-auto grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-2xl text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Paid</p>
                        <p class="text-xl font-black text-green-600">৳{{ number_format($student->fees->where('status', 'paid')->sum('amount'), 0) }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Attendance</p>
                        @php
                            $attendanceCount = $student->attendances->count();
                            $presentCount = $student->attendances->where('status', 'present')->count();
                            $rate = $attendanceCount > 0 ? round(($presentCount / $attendanceCount) * 100) : 0;
                        @endphp
                        <p class="text-xl font-black text-blue-600">{{ $rate }}%</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Details & Contact -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                        <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                            Personal Details
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Phone Number</p>
                                <p class="font-bold text-gray-700">{{ $student->phone ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Date of Birth</p>
                                <p class="font-bold text-gray-700">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d F, Y') : 'Not Provided' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Registration Date</p>
                                <p class="font-bold text-gray-700">{{ $student->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                        <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                            Recent Attendance
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($student->attendances->take(14) as $att)
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-black {{ $att->status == 'present' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}" title="{{ $att->date }}">
                                    {{ $att->status == 'present' ? 'P' : 'A' }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Fee History -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-orange-500 rounded-full"></span>
                            Payment History
                        </h3>
                        <a href="{{ route('students.dues', $student) }}" class="text-xs font-black text-orange-600 uppercase tracking-widest hover:underline">Check Pending Dues</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                    <th class="pb-4">Date</th>
                                    <th class="pb-4">Fee Type</th>
                                    <th class="pb-4">Month/Year</th>
                                    <th class="pb-4">Amount</th>
                                    <th class="pb-4 text-right">Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($student->fees as $fee)
                                    <tr>
                                        <td class="py-4 text-sm font-bold text-gray-500">{{ $fee->created_at->format('d M, Y') }}</td>
                                        <td class="py-4 font-bold text-gray-800">{{ $fee->fee_type }}</td>
                                        <td class="py-4 text-sm text-gray-500">{{ $fee->month }} {{ $fee->year }}</td>
                                        <td class="py-4 font-black text-green-600">৳{{ number_format($fee->amount, 0) }}</td>
                                        <td class="py-4 text-right">
                                            <a href="{{ route('fees.receipt', $fee) }}" class="text-gray-400 hover:text-primary transition">
                                                <svg class="w-5 h-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v4"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-gray-400 italic">No payment records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
