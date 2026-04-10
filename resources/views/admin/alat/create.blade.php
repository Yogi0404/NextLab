@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Alat</h1>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow w-full">

        <form action="{{ route('alat.store') }}" method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Kode Alat -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kode Alat</label>
                <input type="text" name="kode_alat"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: LPT-001">
            </div>

            <!-- Nama Alat -->
            <div>
                <label class="text-sm font-medium text-gray-600">Nama Alat</label>
                <input type="text" name="nama_alat"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Laptop Asus">
            </div>

            <!-- Kategori -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kategori</label>
                <input type="text" name="kategori"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Elektronik">
            </div>

            <!-- Total Stok -->
            <div>
                <label class="text-sm font-medium text-gray-600">Total Stok</label>
                <input type="number" name="total_stok"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="10">
            </div>

            <!-- Kondisi -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kondisi</label>
                <select name="kondisi"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Foto Alat</label>
                <input type="file" name="foto"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2">
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Deskripsi alat (opsional)"></textarea>
            </div>

            <!-- Action -->
            <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">

                <a href="{{ route('alat.index') }}"
                    class="px-5 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition shadow">
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>
@endsection