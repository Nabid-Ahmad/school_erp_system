<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Vehicles</h2>
            <p class="text-sm font-medium text-gray-500">Manage transport vehicles</p>
        </div>
        <a href="{{ route('transport.vehicles.create') }}" class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-purple-600 text-white font-bold rounded-xl shadow hover:bg-purple-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Vehicle
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
                        <th class="px-6 py-4">Vehicle Number</th>
                        <th class="px-6 py-4">Driver Name</th>
                        <th class="px-6 py-4">Driver Phone</th>
                        <th class="px-6 py-4 text-center">Capacity</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($vehicles as $vehicle)
                    <tr class="hover:bg-purple-50/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $vehicle->vehicle_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $vehicle->driver_name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $vehicle->driver_phone }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $vehicle->capacity }} Seats
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('transport.vehicles.destroy', $vehicle) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 font-medium italic">
                            No vehicles found. Add your first vehicle.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
