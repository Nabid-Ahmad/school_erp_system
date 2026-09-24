<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Visitor Management') }}
            </h2>
            <a href="{{ route('visitors.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + New Visitor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-200">
                                <th class="p-3">Name</th>
                                <th class="p-3">Phone</th>
                                <th class="p-3">Purpose</th>
                                <th class="p-3">To Meet</th>
                                <th class="p-3">Check In</th>
                                <th class="p-3">Check Out</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($visitors as $visitor)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="p-3 font-semibold">{{ $visitor->name }}</td>
                                    <td class="p-3">{{ $visitor->phone }}</td>
                                    <td class="p-3">{{ $visitor->purpose }}</td>
                                    <td class="p-3">{{ $visitor->person_to_meet ?? '-' }}</td>
                                    <td class="p-3 text-sm">{{ $visitor->check_in_time->format('d M Y, h:i A') }}</td>
                                    <td class="p-3 text-sm">
                                        @if($visitor->check_out_time)
                                            <span class="text-green-600">{{ $visitor->check_out_time->format('d M Y, h:i A') }}</span>
                                        @else
                                            <span class="text-red-500 font-semibold">Not Checked Out</span>
                                        @endif
                                    </td>
                                    <td class="p-3 flex space-x-2">
                                        @if(!$visitor->check_out_time)
                                        <form action="{{ route('visitors.checkout', $visitor->id) }}" method="POST" onsubmit="return confirm('Check out this visitor?');">
                                            @csrf
                                            <button type="submit" class="bg-orange-500 text-white px-3 py-1 rounded text-sm hover:bg-orange-600">Check Out</button>
                                        </form>
                                        @endif
                                        <a href="{{ route('visitors.edit', $visitor->id) }}" class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600">Edit</a>
                                        
                                        <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-500">No visitors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $visitors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
