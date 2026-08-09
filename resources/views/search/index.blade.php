<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Search Results') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('search') }}" method="GET" class="mb-8">
                <div class="flex items-center bg-white border border-gray-200 rounded-2xl px-4 py-3 shadow-sm focus-within:ring-2 focus-within:ring-primary">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="q" value="{{ $query }}" placeholder="Search students, teachers, classes, subjects, events, expenses..." class="w-full bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-700 placeholder-gray-400">
                    <button type="submit" class="bg-primary text-white px-4 py-1.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition ml-2">Search</button>
                </div>
            </form>

            @if(strlen($query) < 2)
                <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-gray-100">
                    <p class="text-gray-500 font-bold">Type at least 2 characters to search.</p>
                </div>
            @elseif($total === 0)
                <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h5 class="text-xl font-black text-gray-800">No results found</h5>
                    <p class="text-gray-400 mt-1">Nothing matched "{{ $query }}".</p>
                </div>
            @else
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">{{ $total }} result(s) for "{{ $query }}"</p>

                <div class="space-y-8">
                    @if($results['students']->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Students</h3>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
                                @foreach($results['students'] as $student)
                                    <a href="{{ route('students.show', $student) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                                        <div>
                                            <p class="font-black text-gray-800">{{ $student->name }}</p>
                                            <p class="text-xs text-gray-400 font-bold">Roll: {{ $student->roll }} @if($student->schoolClass) | Class {{ $student->schoolClass->name }} @endif</p>
                                        </div>
                                        <span class="text-xs font-bold text-primary">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if($results['teachers']->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Teachers</h3>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
                                @foreach($results['teachers'] as $teacher)
                                    <a href="{{ route('teachers.show', $teacher) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                                        <div>
                                            <p class="font-black text-gray-800">{{ $teacher->name }}</p>
                                            <p class="text-xs text-gray-400 font-bold">ID: {{ $teacher->teacher_id_number }} @if($teacher->subject) | {{ $teacher->subject }} @endif</p>
                                        </div>
                                        <span class="text-xs font-bold text-primary">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if($results['classes']->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Classes</h3>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
                                @foreach($results['classes'] as $class)
                                    <a href="{{ route('classes.edit', $class) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                                        <p class="font-black text-gray-800">Class {{ $class->name }}</p>
                                        <span class="text-xs font-bold text-primary">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if($results['subjects']->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Subjects</h3>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
                                @foreach($results['subjects'] as $subject)
                                    <a href="{{ route('subjects.edit', $subject) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                                        <div>
                                            <p class="font-black text-gray-800">{{ $subject->name }}</p>
                                            @if($subject->schoolClass)
                                                <p class="text-xs text-gray-400 font-bold">Class {{ $subject->schoolClass->name }}</p>
                                            @endif
                                        </div>
                                        <span class="text-xs font-bold text-primary">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if($results['events']->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Events</h3>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
                                @foreach($results['events'] as $event)
                                    <a href="{{ route('events.show', $event) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                                        <div>
                                            <p class="font-black text-gray-800">{{ $event->title }}</p>
                                            @if($event->date)
                                                <p class="text-xs text-gray-400 font-bold">{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</p>
                                            @endif
                                        </div>
                                        <span class="text-xs font-bold text-primary">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if($results['expenses']->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Expenses</h3>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
                                @foreach($results['expenses'] as $expense)
                                    <a href="{{ route('expenses.edit', $expense) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                                        <div>
                                            <p class="font-black text-gray-800">{{ $expense->title }}</p>
                                            <p class="text-xs text-gray-400 font-bold">৳{{ number_format($expense->amount, 2) }} @if($expense->date) | {{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }} @endif</p>
                                        </div>
                                        <span class="text-xs font-bold text-primary">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
