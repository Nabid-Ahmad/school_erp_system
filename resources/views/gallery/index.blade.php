<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Gallery') }}
            </h2>
            <a href="{{ route('galleries.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-purple-700 transition">
                + Add Image
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($galleries as $gallery)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 relative group">
                        <img src="{{ filter_var($gallery->image, FILTER_VALIDATE_URL) ? $gallery->image : asset('storage/' . $gallery->image) }}" class="w-full h-48 object-cover" alt="{{ $gallery->title }}">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 truncate">{{ $gallery->title }}</h3>
                        </div>
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-4">
                            <form action="{{ route('galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                @csrf @method('DELETE')
                                <button class="bg-danger text-white p-2 rounded-lg hover:scale-110 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        No gallery images found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
