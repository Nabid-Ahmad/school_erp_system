<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Visitor Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('visitors.update', $visitor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('name', $visitor->name) }}">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Phone <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('phone', $visitor->phone) }}">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Purpose <span class="text-red-500">*</span></label>
                            <input type="text" name="purpose" class="w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('purpose', $visitor->purpose) }}">
                            @error('purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Person To Meet</label>
                            <input type="text" name="person_to_meet" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('person_to_meet', $visitor->person_to_meet) }}">
                            @error('person_to_meet') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Check In Time <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="check_in_time" class="w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('check_in_time', $visitor->check_in_time->format('Y-m-d\TH:i')) }}">
                            @error('check_in_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Check Out Time</label>
                            <input type="datetime-local" name="check_out_time" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('check_out_time', $visitor->check_out_time ? $visitor->check_out_time->format('Y-m-d\TH:i') : '') }}">
                            @error('check_out_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Note / Remarks</label>
                            <textarea name="note" class="w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('note', $visitor->note) }}</textarea>
                            @error('note') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center space-x-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Update Visitor</button>
                            <a href="{{ route('visitors.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
