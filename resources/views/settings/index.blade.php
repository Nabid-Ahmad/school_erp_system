<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('School Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl mb-6 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2.5rem] border border-gray-100">
                <div class="p-10 text-gray-900">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">School Name</label>
                                    <input type="text" name="school_name" value="{{ $settings['school_name'] ?? '' }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">School Address</label>
                                    <textarea name="school_address" rows="3" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm">{{ $settings['school_address'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Contact Phone</label>
                                    <input type="text" name="school_phone" value="{{ $settings['school_phone'] ?? '' }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Contact Email</label>
                                    <input type="email" name="school_email" value="{{ $settings['school_email'] ?? '' }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-primary font-bold shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">School Logo</label>
                                    <div class="flex items-center gap-4">
                                        @if(isset($settings['school_logo']))
                                            <img src="{{ filter_var($settings['school_logo'] ?? '', FILTER_VALIDATE_URL) ? $settings['school_logo'] : asset('storage/'.($settings['school_logo'] ?? '')) }}" class="w-16 h-16 rounded-2xl object-contain bg-gray-50 p-2">
                                        @endif
                                        <input type="file" name="school_logo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 pt-10 border-t border-gray-50 flex justify-end">
                            <button type="submit" class="bg-primary text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                                Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Developer Note -->
            <div class="mt-8 bg-blue-50 p-6 rounded-3xl border border-blue-100 flex gap-4 items-center">
                <div class="text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm text-blue-600/80 font-medium italic">These settings will automatically update the branding on all ID Cards and Money Receipts.</p>
            </div>
        </div>
    </div>
</x-app-layout>
