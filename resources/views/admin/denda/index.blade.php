@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Denda & Pembayaran</h1>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Terlambat</th>
                    <th class="px-4 py-3">Total Denda</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @forelse($peminjamans as $item)

                @if($item->denda_hitung > 0)
                <tr class="border-t hover:bg-gray-50">

                    <!-- NAMA -->
                    <td class="px-4 py-3">
                        {{ $item->user->name }}
                    </td>

                    <!-- ALAT -->
                    <td class="px-4 py-3">
                        {{ $item->alat->nama_alat }}
                    </td>

                    <!-- TELAT -->
                    <td class="px-4 py-3 text-red-500 font-semibold">
                        {{ $item->telat_hari }} Hari
                    </td>

                    <!-- DENDA -->
                    <td class="px-4 py-3 font-semibold text-red-500">
                        Rp {{ number_format($item->denda_hitung, 0, ',', '.') }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3">
                        @if($item->status == 'dikembalikan')
                        <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-lg">
                            Sudah Bayar
                        </span>
                        @else
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-lg">
                            Belum Bayar
                        </span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="px-4 py-3 text-center">
                        @if($item->status != 'dikembalikan')
                        <a href="{{ route('peminjaman.formBayar', $item->id) }}"
                            class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs">
                            Bayar
                        </a>
                        @else
                        <span class="text-xs text-gray-400">Selesai</span>
                        @endif
                    </td>

                </tr>
                @endif

                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">
                        Tidak ada data denda
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>
@endsection