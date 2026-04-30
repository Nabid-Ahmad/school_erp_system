<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('teachers.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Teacher: ') }} {{ $teacher->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="image" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Teacher Profile Photo</label>
                            @if($teacher->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$teacher->image) }}" class="w-20 h-20 rounded-xl object-cover border border-gray-100 shadow-sm">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 transition cursor-pointer shadow-sm">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Teacher Name</label>
                                <input type="text" name="name" id="name" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm" value="{{ old('name', $teacher->name) }}" required>
                                @error('name') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="designation" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Designation</label>
                                <input type="text" name="designation" id="designation" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm" value="{{ old('designation', $teacher->designation) }}">
                                @error('designation') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="subject" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Main Subject</label>
                                <input type="text" name="subject" id="subject" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm" value="{{ old('subject', $teacher->subject) }}" required>
                                @error('subject') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm" value="{{ old('phone', $teacher->phone) }}">
                                @error('phone') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="salary" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Monthly Salary (৳)</label>
                                <input type="number" name="salary" id="salary" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm" value="{{ old('salary', $teacher->salary) }}" required>
                                @error('salary') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="joining_date" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Joining Date</label>
                                <input type="date" name="joining_date" id="joining_date" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm" value="{{ old('joining_date', $teacher->joining_date) }}">
                                @error('joining_date') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Update Teacher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
