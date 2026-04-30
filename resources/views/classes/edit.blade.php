<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('classes.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Class: ') }} {{ $class->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('classes.update', $class) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Class Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('name', $class->name) }}" required>
                            @error('name')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $monthlyFee = $class->feeStructures->where('fee_type', 'Monthly Fee')->first()->amount ?? 0;
                            $admissionFee = $class->feeStructures->where('fee_type', 'Admission Fee')->first()->amount ?? 0;
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="monthly_fee" class="block text-sm font-medium text-gray-700">Monthly Fee (৳)</label>
                                <input type="number" step="0.01" name="monthly_fee" id="monthly_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('monthly_fee', $monthlyFee) }}" required>
                                @error('monthly_fee')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="admission_fee" class="block text-sm font-medium text-gray-700">Admission Fee (৳)</label>
                                <input type="number" step="0.01" name="admission_fee" id="admission_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" value="{{ old('admission_fee', $admissionFee) }}" required>
                                @error('admission_fee')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Update Class
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
