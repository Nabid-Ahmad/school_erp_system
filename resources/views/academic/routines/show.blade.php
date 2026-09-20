<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $schoolClass->name }} - Timetable</h2>
            <p class="text-sm font-medium text-gray-500">Weekly class schedule</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('routines.index') }}" class="px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl shadow hover:bg-gray-50 transition-colors">
                Back to Classes
            </a>
            @can('manage classes')
            <a href="{{ route('routines.create') }}" class="px-5 py-2.5 bg-purple-600 text-white font-bold rounded-xl shadow-lg hover:bg-purple-700 transition-colors">
                Add Slot
            </a>
            @endcan
        </div>
    </div>

    <div class="bg-white/90 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto p-4 md:p-8">
            <div class="min-w-[800px] flex flex-col gap-6">
                @foreach($days as $day)
                    <div class="flex items-stretch bg-gray-50/50 rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                        <!-- Day Label -->
                        <div class="w-32 flex-shrink-0 bg-purple-100 flex items-center justify-center border-r border-purple-200">
                            <span class="text-purple-800 font-black tracking-widest uppercase text-sm -rotate-90 md:rotate-0">{{ $day }}</span>
                        </div>
                        
                        <!-- Routine Slots -->
                        <div class="flex-1 p-4 flex gap-4 overflow-x-auto items-center min-h-[100px]">
                            @if(isset($routines[$day]) && $routines[$day]->count() > 0)
                                @foreach($routines[$day] as $slot)
                                <div class="relative group flex-shrink-0 w-64 bg-white p-4 rounded-xl shadow border-l-4 border-purple-500 hover:shadow-lg transition-all hover:-translate-y-1">
                                    @can('manage classes')
                                    <form action="{{ route('routines.destroy', $slot->id) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 p-1" onclick="return confirm('Remove this slot?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @endcan
                                    
                                    <div class="text-[10px] font-black text-gray-400 mb-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                    </div>
                                    <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $slot->subject->name }}</h4>
                                    <div class="flex justify-between items-end mt-2">
                                        <div class="text-sm font-medium text-purple-600">{{ $slot->teacher->name }}</div>
                                        @if($slot->room_number)
                                        <div class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded">Room: {{ $slot->room_number }}</div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-gray-300 font-medium italic text-sm w-full text-center">No classes scheduled</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</x-app-layout>
