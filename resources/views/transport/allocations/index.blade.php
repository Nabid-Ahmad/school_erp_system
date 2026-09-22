<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Transport Allocations</h2>
            <p class="text-sm font-medium text-gray-500">Allocate students to bus routes</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Allocation Form -->
        <div class="lg:col-span-1">
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Allocate Student</h3>
                <form action="{{ route('transport.allocations.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Student</label>
                        <select name="student_id" required class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            <option value="">Select a student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ optional($student->user)->name ?? 'Student ID: ' . $student->id }} ({{ $student->admission_number }})</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Route</label>
                        <select name="transport_route_id" required class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50">
                            <option value="">Select a route...</option>
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}">{{ $route->name }} (${{ number_format($route->fare, 2) }})</option>
                            @endforeach
                        </select>
                        @error('transport_route_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 bg-purple-600 text-white font-bold rounded-xl shadow hover:bg-purple-700 transition-colors">
                        Assign Route
                    </button>
                </form>
            </div>
        </div>

        <!-- Allocations List -->
        <div class="lg:col-span-2">
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Student</th>
                                <th class="px-6 py-4">Route Name</th>
                                <th class="px-6 py-4">Monthly Fare</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($allocations as $allocation)
                            <tr class="hover:bg-purple-50/30 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ optional($allocation->student->user)->name ?? 'Unknown Student' }}
                                    <div class="text-xs font-normal text-gray-500">{{ $allocation->student->admission_number }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-bold">{{ $allocation->route->name }}</td>
                                <td class="px-6 py-4 text-purple-600 font-black">${{ number_format($allocation->route->fare, 2) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('transport.allocations.destroy', $allocation) }}" method="POST" class="inline-block" onsubmit="return confirm('Remove student from this route?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Unassign</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 font-medium italic">
                                    No students allocated to transport yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
