@extends('layouts.user')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500">Ringkasan aktivitas peminjaman kamu</p>
    </div>

    <!-- CARD STATS -->
    <div class="grid md:grid-cols-3 gap-4 mb-6">

        <!-- Dipinjam -->
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 mb-1">Sedang Dipinjam</p>
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-blue-600">{{ $dipinjam }}</h2>
                <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                    📦
                </div>
            </div>
        </div>

        <!-- Request -->
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 mb-1">Menunggu Pengembalian</p>
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-purple-500">{{ $requestKembali }}</h2>
                <div class="bg-purple-100 text-purple-600 p-2 rounded-lg">
                    ⏳
                </div>
            </div>
        </div>

        <!-- Total -->
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 mb-1">Total Riwayat</p>
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-green-600">{{ $total }}</h2>
                <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                    📊
                </div>
            </div>
        </div>

    </div>

    <!-- TABEL -->
    <div class="bg-white rounded-2xl shadow">

        <!-- Header -->
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-semibold text-gray-700">Peminjaman Terbaru</h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Alat</th>
                        <th class="px-4 py-3">Tanggal Pinjam</th>
                        <th class="px-4 py-3">Tanggal Kembali</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @forelse($latest as $item)
                    <tr class="border-t hover:bg-gray-50 transition">

                        <td class="px-4 py-3 font-medium">
                            {{ $item->alat->nama_alat }}
                        </td>

                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($item->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs">Pending</span>

                            @elseif($item->status == 'dipinjam')
                                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs">Dipinjam</span>

                            @elseif($item->status == 'request_kembali')
                                <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs">Menunggu</span>

                            @elseif($item->status == 'dikembalikan')
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">Selesai</span>

                            @elseif($item->status == 'ditolak')
                                <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">Ditolak</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            Belum ada peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>
@endsection