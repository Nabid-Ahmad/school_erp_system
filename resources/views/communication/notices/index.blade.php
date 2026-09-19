<x-app-layout>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Digital Notice Board</h2>
            <p class="text-sm font-medium text-gray-500">Important announcements and updates</p>
        </div>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('communication.notices.create') }}" class="px-6 py-2.5 bg-blue-500 text-white font-bold rounded-xl shadow-lg hover:bg-blue-600 hover:-translate-y-0.5 transition-all">
            Publish Notice
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($notices as $notice)
        <div class="bg-yellow-50/90 backdrop-blur-md p-6 rounded-[2rem] shadow-lg border-t-8 border-yellow-400 relative group transition-all hover:-translate-y-1 hover:shadow-xl">
            @if(auth()->user()->role === 'admin')
            <form action="{{ route('communication.notices.destroy', $notice) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 bg-white/80 p-1.5 rounded-full shadow-sm" onclick="return confirm('Are you sure?')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
            @endif
            
            <div class="flex items-center gap-2 mb-4">
                <span class="px-3 py-1 bg-white/60 text-yellow-800 text-[10px] font-black uppercase tracking-wider rounded-lg">
                    Target: {{ $notice->target_audience }}
                </span>
                <span class="text-xs font-bold text-yellow-600">
                    {{ $notice->created_at->format('d M, Y') }}
                </span>
            </div>
            
            <h3 class="text-xl font-black text-gray-900 mb-3">{{ $notice->title }}</h3>
            <div class="text-gray-700 text-sm leading-relaxed mb-4 whitespace-pre-wrap">{{ $notice->content }}</div>
            
            @if($notice->expires_at)
            <div class="text-xs font-bold text-red-500/80 pt-4 border-t border-yellow-200/50">
                Expires: {{ $notice->expires_at->format('d M, Y') }}
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full py-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p class="text-gray-500 font-bold text-lg">No notices published yet.</p>
        </div>
        @endforelse
    </div>
</div>
</x-app-layout>
