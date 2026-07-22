<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold" required>
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">User Role</label>
                            <select name="role" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold">
                                <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Password (Leave blank to keep current)</label>
                                <input type="password" name="password" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold">
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary font-bold">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Assign Permissions</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-xl">
                                @foreach($permissions as $permission)
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
                                            {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600 font-bold capitalize">{{ str_replace('manage ', '', $permission->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-primary/20 hover:opacity-90 transition">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
