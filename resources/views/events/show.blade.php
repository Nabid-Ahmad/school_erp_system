<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Event Details') }}
            </h2>
            <a href="{{ route('events.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-200 transition">
                &larr; Back to Events
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                @if($event->image)
                    <img src="{{ filter_var($event->image, FILTER_VALIDATE_URL) ? $event->image : asset('storage/' . $event->image) }}" class="w-full h-64 md:h-96 object-cover" alt="{{ $event->title }}">
                @endif
                <div class="p-8">
                    <div class="text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ $event->date->format('M d, Y') }}</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $event->title }}</h3>
                    <p class="text-gray-500 text-base leading-relaxed">{{ $event->description }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
