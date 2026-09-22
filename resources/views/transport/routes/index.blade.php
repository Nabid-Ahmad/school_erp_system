<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Transport Routes</h2>
            <p class="text-sm font-medium text-gray-500">Manage school bus routes</p>
        </div>
        <a href="{{ route('transport.routes.create') }}" class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-purple-600 text-white font-bold rounded-xl shadow hover:bg-purple-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Route
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white/20 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Route Name</th>
                        <th class="px-6 py-4">Path</th>
                        <th class="px-6 py-4">Monthly Fare</th>
                        <th class="px-6 py-4 text-center">Allocated Students</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($routes as $route)
                    <tr class="hover:bg-purple-50/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $route->name }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="text-xs font-bold text-gray-400">FROM</span> {{ $route->start_point }} 
                            <svg class="w-4 h-4 inline-block mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            <span class="text-xs font-bold text-gray-400">TO</span> {{ $route->end_point }}
                        </td>
                        <td class="px-6 py-4 text-purple-600 font-black">${{ number_format($route->fare, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                {{ $route->allocations_count }} Students
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('transport.routes.destroy', $route) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this route?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 font-medium italic">
                            No routes found. Create a new route.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
