@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
        <p class="text-sm text-gray-500">Perbarui data pengguna</p>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow w-full">

        <form action="{{ route('user.update', $user->id) }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Kosongkan jika tidak ingin mengubah">
            </div>

            <!-- Role -->
            <div>
                <label class="text-sm font-medium text-gray-600">Role</label>
                <select name="role"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>

                </select>
            </div>

            <!-- Action -->
            <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">

                <a href="{{ route('user.index') }}"
                    class="px-5 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition shadow">
                    Update User
                </button>

            </div>

        </form>

    </div>

</div>
@endsection