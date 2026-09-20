<x-app-layout>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Class Routines</h2>
            <p class="text-sm font-medium text-gray-500">Select a class to view or manage its timetable</p>
        </div>
        @can('manage classes')
        <a href="{{ route('routines.create') }}" class="px-6 py-2.5 bg-purple-600 text-white font-bold rounded-xl shadow-lg hover:bg-purple-700 hover:-translate-y-0.5 transition-all">
            Add New Slot
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($classes as $schoolClass)
        <a href="{{ route('routines.show', $schoolClass->id) }}" class="group block bg-white/80 backdrop-blur-md border border-white/20 p-6 rounded-[2rem] shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-bl-[100px] opacity-10 group-hover:opacity-20 transition-opacity"></div>
            
            <h3 class="text-3xl font-black text-gray-900 mb-2">{{ $schoolClass->name }}</h3>
            <p class="text-gray-500 font-medium text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                {{ $schoolClass->students_count }} Students
            </p>
            
            <div class="mt-6 flex justify-end">
                <span class="inline-flex items-center gap-1 text-sm font-bold text-purple-600 group-hover:text-purple-800">
                    View Timetable
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-full py-12 text-center text-gray-400 font-medium bg-white/50 rounded-3xl">
            No classes found. Please create a class first.
        </div>
        @endforelse
    </div>
</div>
</x-app-layout>
