@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>

        <a href="{{ route('user.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition shadow">
            + Tambah User
        </a>
    </div>

    <!-- ===================== -->
    <!-- 🔵 ADMIN + PETUGAS -->
    <!-- ===================== -->
    <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">

        <div class="p-4 border-b font-semibold text-gray-700">
            Admin & Petugas
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">User</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($adminsPetugas as $user)
                <tr class="hover:bg-gray-50">

                    <!-- USER -->
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                        <span class="font-medium">{{ $user->name }}</span>
                    </td>

                    <!-- EMAIL -->
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <!-- ROLE -->
                    <td class="px-6 py-4">
                        @if($user->role == 'admin')
                        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">Admin</span>
                        @else
                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">Petugas</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">

                            <!-- EDIT -->
                            <a href="{{ route('user.edit', $user->id) }}"
                                class="bg-blue-50 hover:bg-blue-100 p-2 rounded-lg group">
                                <img src="{{ asset('storage/img/edit.png') }}"
                                    class="w-5 h-5 group-hover:scale-110">
                            </a>

                            <!-- DELETE -->
                            <button type="button"
                                onclick="openDeleteModal('{{ route('user.destroy', $user->id) }}')"
                                class="bg-red-50 hover:bg-red-100 p-2 rounded-lg group">
                                <img src="{{ asset('storage/img/delete.png') }}"
                                    class="w-5 h-5 group-hover:scale-110">
                            </button>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">
                        Tidak ada admin/petugas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- ===================== -->
    <!-- ⚪ USER -->
    <!-- ===================== -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-4 border-b font-semibold text-gray-700">
            User
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">User</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($usersOnly as $user)
                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                        <span class="font-medium">{{ $user->name }}</span>
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">
                            User
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('user.edit', $user->id) }}"
                                class="bg-blue-50 hover:bg-blue-100 p-2 rounded-lg group">
                                <img src="{{ asset('storage/img/edit.png') }}"
                                    class="w-5 h-5 group-hover:scale-110">
                            </a>

                            <button type="button"
                                onclick="openDeleteModal('{{ route('user.destroy', $user->id) }}')"
                                class="bg-red-50 hover:bg-red-100 p-2 rounded-lg group">
                                <img src="{{ asset('storage/img/delete.png') }}"
                                    class="w-5 h-5 group-hover:scale-110">
                            </button>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">
                        Tidak ada user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>
@endsection