@extends('layouts.petugas')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Approval Pengembalian</h1>
        <p class="text-sm text-gray-500">Setujui atau tolak pengembalian alat</p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            <!-- Head -->
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Pinjam</th>
                    <th class="px-4 py-3">Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="text-gray-700">

                @forelse ($peminjamans as $item)
                <tr class="border-t hover:bg-gray-50">

                    <!-- Nama -->
                    <td class="px-4 py-3 font-medium">
                        {{ $item->user->name }}
                    </td>

                    <!-- Alat -->
                    <td class="px-4 py-3">
                        {{ $item->alat->nama_alat }}
                    </td>

                    <!-- Jumlah -->
                    <td class="px-4 py-3">
                        {{ $item->jumlah }}
                    </td>

                    <!-- Tanggal -->
                    <td class="px-4 py-3">
                        {{ $item->tanggal_pinjam }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->tanggal_kembali }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3">
                        @switch(trim($item->status))

                            @case('pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                    Pending
                                </span>
                                @break

                            @case('dipinjam')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                    Dipinjam
                                </span>
                                @break

                            @case('request_kembali')
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">
                                    Request Kembali
                                </span>
                                @break

                            @case('dikembalikan')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                    Dikembalikan
                                </span>
                                @break

                            @case('ditolak')
                                <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">
                                    Ditolak
                                </span>
                                @break

                        @endswitch
                    </td>

                    <!-- AKSI -->
                    <td class="px-4 py-3 text-center space-x-2">

                        {{-- 🔁 KHUSUS APPROVAL PENGEMBALIAN --}}
                        @if(trim($item->status) == 'request_kembali')

                            <!-- Approve -->
                            <form action="{{ route('peminjaman.approveKembali', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                    Approve
                                </button>
                            </form>

                            <!-- Tolak -->
                            <form action="{{ route('peminjaman.tolakKembali', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                    Tolak
                                </button>
                            </form>

                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>
@endsection