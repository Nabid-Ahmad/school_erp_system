<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('students.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Student') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Student Photo</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 transition cursor-pointer shadow-sm">
                            @error('image')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Student Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="roll" class="block text-sm font-medium text-gray-700">Roll Number (Unique)</label>
                                <input type="text" name="roll" id="roll" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('roll') }}" required>
                                @error('roll')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="school_class_id" class="block text-sm font-medium text-gray-700">Class</label>
                                <select name="school_class_id" id="school_class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" required onchange="updateAdmissionFee(this)">
                                    <option value="" disabled selected>Select a class</option>
                                    @foreach($classes as $class)
                                        @php
                                            $admFee = $class->feeStructures->where('fee_type', 'Admission Fee')->first()->amount ?? 0;
                                        @endphp
                                        <option value="{{ $class->id }}" data-admission-fee="{{ $admFee }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                            Class {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-2xl flex justify-between items-center">
                            <div>
                                <h4 class="text-blue-800 font-black text-sm uppercase tracking-widest">Admission Fee</h4>
                                <p class="text-xs text-blue-600">The amount to be paid for this class</p>
                            </div>
                            <div class="text-2xl font-black text-primary">
                                ৳<span id="admission_fee_display">0</span>
                            </div>
                        </div>

                        <script>
                            function updateAdmissionFee(select) {
                                let option = select.options[select.selectedIndex];
                                let fee = option.getAttribute('data-admission-fee') || 0;
                                document.getElementById('admission_fee_display').innerText = fee;
                            }
                            
                            // Initialize on load if old value exists
                            window.addEventListener('load', () => {
                                let select = document.getElementById('school_class_id');
                                if(select.value) updateAdmissionFee(select);
                            });
                        </script>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('dob') }}">
                                @error('dob')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Save Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
