<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('name')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('email')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Role</label>
                        <select name="role" class="w-full border rounded px-3 py-2">
                            <option value="user" @selected(old('role', $user->role) == 'user')>User</option>
                            <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                        </select>
                        @error('role')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Password Baru</label>
                        <input type="password" name="password" 
                            class="w-full border rounded px-3 py-2">
                        <p class="text-sm text-gray-500 mt-1">Kosongkan jika password tidak diubah.</p>
                        @error('password')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>

                        <a href="{{ route('users.index') }}" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>