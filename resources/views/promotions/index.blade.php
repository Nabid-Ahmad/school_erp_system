<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Promotion') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl mb-6 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-6 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-lg font-black text-gray-800">Mass Promotion</h3>
                        <p class="text-sm text-gray-400">Move all students from one class to another (e.g., Year-end promotion).</p>
                    </div>

                    <form action="{{ route('promotions.promote') }}" method="POST" class="space-y-6" onsubmit="return confirm('Are you sure you want to promote ALL students? This action cannot be undone.')">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Promote From</label>
                                <select name="from_class_id" class="w-full bg-gray-50 border-none rounded-2xl p-5 focus:ring-2 focus:ring-primary font-black text-lg shadow-sm">
                                    <option value="" disabled selected>Select Current Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">Class {{ $class->name }} ({{ $class->students_count }} Students)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-center md:pt-8">
                                <div class="bg-primary/10 p-4 rounded-full text-primary animate-pulse">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Promote To</label>
                                <select name="to_class_id" class="w-full bg-gray-50 border-none rounded-2xl p-5 focus:ring-2 focus:ring-primary font-black text-lg shadow-sm">
                                    <option value="" disabled selected>Select Next Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">Class {{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-12 flex justify-center border-t border-gray-50 pt-10">
                            <button type="submit" class="bg-primary text-white px-12 py-5 rounded-[2rem] font-black text-lg shadow-2xl shadow-primary/30 hover:scale-105 transition-all">
                                Process Mass Promotion
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-8 bg-blue-50 p-6 rounded-3xl border border-blue-100 flex gap-4 items-start">
                <div class="text-blue-500 pt-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-800">Important Note</h4>
                    <p class="text-sm text-blue-600/80 leading-relaxed mt-1">This tool will update the class for all students in the selected "Promote From" class. Make sure you have finished all examinations and fee collections for the current year before proceeding.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
