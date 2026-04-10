@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Peminjaman</h1>
        
    </div>

    <!-- Card Form FULL WIDTH -->
    <div class="bg-white p-6 rounded-xl shadow w-full">

        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- User -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Peminjam
                </label>
                <select name="user_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Alat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Pilih Alat
                </label>
                <select name="alat_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Alat --</option>
                    @foreach($alats as $alat)
                        <option value="{{ $alat->id }}"
                            {{ $alat->stok_tersedia == 0 ? 'disabled' : '' }}>
                            {{ $alat->nama_alat }} (Stok: {{ $alat->stok_tersedia }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Jumlah Pinjam
                </label>
                <input type="number" name="jumlah" min="1" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan jumlah">
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Pinjam
                    </label>
                    <input type="date" name="tanggal_pinjam" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Kembali
                    </label>
                    <input type="date" name="tanggal_kembali" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm p-3 rounded-lg">
                Setelah disimpan, peminjaman akan berstatus <b>Dipinjam</b>.
            </div>

            <!-- Button -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('peminjaman.index') }}"
                    class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>
@endsection