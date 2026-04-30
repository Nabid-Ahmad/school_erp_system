<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Fee Structure') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($classes as $class)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-green-50 border-b border-green-100">
                            <h3 class="text-xl font-black text-green-800">Class: {{ $class->name }}</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('fee-structures.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="school_class_id" value="{{ $class->id }}">
                                
                                <div class="grid grid-cols-2 gap-4 items-end">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Fee Type</label>
                                        <select name="fee_type" class="w-full rounded-xl border-gray-200 text-sm font-bold p-2.5">
                                            @foreach($feeTypes as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Amount (৳)</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="amount" class="w-full rounded-xl border-gray-200 text-sm font-bold p-2.5" placeholder="0.00" required>
                                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700 transition">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="mt-8">
                                <h4 class="text-sm font-black text-gray-800 mb-4 uppercase tracking-widest">Current Fees</h4>
                                <div class="space-y-2">
                                    @forelse($class->feeStructures as $structure)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-100">
                                            <span class="text-sm font-bold text-gray-600">{{ $structure->fee_type }}</span>
                                            <span class="text-sm font-black text-primary">৳{{ number_format($structure->amount, 2) }}</span>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-400 italic">No fees defined yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
