@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-semibold mb-6">Edit Peminjaman</h2>

        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- GRID 2 KOLOM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- USER -->
                <div>
                    <label class="block text-sm mb-1">User</label>
                    <select name="user_id" class="w-full border rounded-lg p-2">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" 
                                {{ $peminjaman->user_id == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- ALAT -->
                <div>
                    <label class="block text-sm mb-1">Alat</label>
                    <select name="alat_id" class="w-full border rounded-lg p-2">
                        @foreach($alat as $a)
                            <option value="{{ $a->id }}"
                                {{ $peminjaman->alat_id == $a->id ? 'selected' : '' }}>
                                {{ $a->nama_alat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TANGGAL PINJAM -->
                <div>
                    <label class="block text-sm mb-1">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam"
                        value="{{ $peminjaman->tanggal_pinjam }}"
                        class="w-full border rounded-lg p-2">
                </div>

                <!-- TANGGAL KEMBALI -->
                <div>
                    <label class="block text-sm mb-1">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali"
                        value="{{ $peminjaman->tanggal_kembali }}"
                        class="w-full border rounded-lg p-2">
                </div>

                <!-- STATUS (FULL BARIS) -->
                <div class="md:col-span-2">
                    <label class="block text-sm mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg p-2">
                        <option value="pending" {{ $peminjaman->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="ditolak" {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('peminjaman.index') }}"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-sm">
                    Batal
                </a>

                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">
                    Update
                </button>
            </div>

        </form>

    </div>

</div>
@endsection