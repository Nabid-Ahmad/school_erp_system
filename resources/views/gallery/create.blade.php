<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Gallery Image') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Image Title</label>
                            <input type="text" name="title" id="title" class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary p-4" required placeholder="e.g. Annual Sports Day 2026">
                        </div>

                        <div class="mb-6">
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Select Image</label>
                            <input type="file" name="image" id="image" class="w-full border-2 border-dashed border-gray-200 rounded-xl p-8 hover:border-primary transition cursor-pointer" required>
                            <p class="text-xs text-gray-400 mt-2">Max size: 2MB (JPG, PNG, GIF)</p>
                        </div>

                        <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition">
                            Upload to Gallery
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
