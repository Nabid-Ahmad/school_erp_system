<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage School Events') }}
            </h2>
            <a href="{{ route('events.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition">
                + Create Event
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($events as $event)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 flex flex-col md:flex-row">
                        @if($event->image)
                            <img src="{{ filter_var($event->image, FILTER_VALIDATE_URL) ? $event->image : asset('storage/' . $event->image) }}" class="w-full md:w-48 h-48 md:h-auto object-cover" alt="{{ $event->title }}">
                        @else
                            <div class="w-full md:w-48 h-48 md:h-auto bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-xs font-bold text-primary uppercase tracking-widest mb-1">{{ $event->date->format('M d, Y') }}</div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-2">{{ $event->description }}</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-50 text-right">
                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200/60 px-3 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-all shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Delete Event
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl">
                        No events scheduled.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
