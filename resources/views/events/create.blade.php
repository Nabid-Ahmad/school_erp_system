<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Event Title</label>
                                <input type="text" name="title" class="w-full rounded-xl border-gray-200 p-4" required placeholder="e.g. Prize Giving Ceremony">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Event Date</label>
                                <input type="date" name="date" class="w-full rounded-xl border-gray-200 p-4" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 p-4" placeholder="Briefly describe the event..."></textarea>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Event Banner (Optional)</label>
                            <input type="file" name="image" class="w-full border-2 border-dashed border-gray-200 rounded-xl p-8 hover:border-primary transition">
                        </div>

                        <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition">
                            Create Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
