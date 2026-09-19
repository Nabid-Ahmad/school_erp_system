<x-app-layout>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Leave Applications</h2>
            <p class="text-sm font-medium text-gray-500">Manage and track leaves</p>
        </div>
        <a href="{{ route('hr.leaves.create') }}" class="px-6 py-2.5 bg-amber-500 text-white font-bold rounded-xl shadow-lg hover:bg-amber-600 hover:-translate-y-0.5 transition-all">
            Apply for Leave
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-100">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-wider">Leave Type</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaves as $leave)
                    <tr class="bg-white border-b hover:bg-amber-50/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $leave->user?->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 font-bold uppercase text-xs">{{ $leave->leave_type }}</td>
                        <td class="px-6 py-4 text-sm">{{ $leave->start_date->format('d M') }} to {{ $leave->end_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($leave->status === 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Approved</span>
                            @elseif($leave->status === 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">Rejected</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(auth()->user()->role === 'admin' && $leave->status === 'pending')
                            <form action="{{ route('hr.leaves.status', $leave) }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="text-green-600 hover:text-green-800 font-bold text-sm bg-green-50 px-3 py-1 rounded-lg transition mr-2">Approve</button>
                            </form>
                            <form action="{{ route('hr.leaves.status', $leave) }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm bg-red-50 px-3 py-1 rounded-lg transition">Reject</button>
                            </form>
                            @else
                            <button onclick="alert('{{ addslashes($leave->reason) }}')" class="text-purple-600 font-bold text-sm hover:underline">View Reason</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                No leave applications found.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
