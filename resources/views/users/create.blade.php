<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                &larr; Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New User') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                            <input type="text" name="name" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold" required>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold" required>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">User Role</label>
                            <select name="role" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold">
                                <option value="staff">Staff</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Password</label>
                                <input type="password" name="password" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold" required>
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Assign Permissions</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-xl">
                                @foreach($permissions as $permission)
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-600 font-bold capitalize">{{ str_replace('manage ', '', $permission->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-primary/20 hover:opacity-90 transition">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
