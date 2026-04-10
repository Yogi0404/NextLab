@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Pengembalian</h1>

        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
            + Proses Pengembalian
        </button>
    </div>

    <!-- Search -->
    <div class="bg-white p-4 rounded-xl shadow mb-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">

        <input type="text" placeholder="Cari nama / alat..."
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-green-500">

        <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full md:w-1/4">
            <option>Semua Status</option>
            <option>Belum Kembali</option>
            <option>Sudah Kembali</option>
        </select>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm text-left">

            <!-- Head -->
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Tanggal Pinjam</th>
                    <th class="px-4 py-3">Jatuh Tempo</th>
                    <th class="px-4 py-3">Denda</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="text-gray-700">

                <!-- Row 1 -->
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">Budi Santoso</td>
                    <td class="px-4 py-3">Laptop Asus</td>
                    <td class="px-4 py-3">20 Apr 2024</td>
                    <td class="px-4 py-3">25 Apr 2024</td>
                    <td class="px-4 py-3 text-red-500 font-semibold">Rp 10.000</td>
                    <td class="px-4 py-3">
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-lg">
                            Terlambat
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700">
                            Kembalikan
                        </button>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">Siti Aminah</td>
                    <td class="px-4 py-3">Proyektor Epson</td>
                    <td class="px-4 py-3">18 Apr 2024</td>
                    <td class="px-4 py-3">22 Apr 2024</td>
                    <td class="px-4 py-3 text-gray-500">Rp 0</td>
                    <td class="px-4 py-3">
                        <span class="bg-yellow-100 text-yellow-600 text-xs px-2 py-1 rounded-lg">
                            Belum Kembali
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700">
                            Kembalikan
                        </button>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">Andi Wijaya</td>
                    <td class="px-4 py-3">Kamera Canon</td>
                    <td class="px-4 py-3">15 Apr 2024</td>
                    <td class="px-4 py-3">19 Apr 2024</td>
                    <td class="px-4 py-3 text-gray-500">Rp 0</td>
                    <td class="px-4 py-3">
                        <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-lg">
                            Sudah Kembali
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="text-xs text-gray-400">Selesai</span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>
@endsection