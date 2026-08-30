<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Salary Sheet') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-4 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                    Select Month and Year
                </h3>
                
                <form action="{{ route('payrolls.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Month</label>
                            <select name="month" required class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-purple-500 font-bold shadow-sm">
                                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                                    <option value="{{ $m }}" {{ $m == now()->format('F') ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Year</label>
                            <input type="number" name="year" value="{{ date('Y') }}" required class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-purple-500 font-bold shadow-sm">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-50">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-purple-200 transition-all hover:scale-105">
                            Generate Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
