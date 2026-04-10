@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Peminjaman</h1>

        <a href="{{ route('peminjaman.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
            + Tambah Peminjaman
        </a>
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
                    <th class="px-4 py-3">Tanggal Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="text-gray-700">
                @forelse ($peminjaman as $p)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">{{ $p->user->name }}</td>
                    <td class="px-4 py-3">{{ $p->alat->nama_alat }}</td>

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3">
                        @if($p->status == 'pending')
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-lg">Pending</span>
                        @elseif($p->status == 'dipinjam')
                        <span class="bg-yellow-100 text-yellow-600 text-xs px-2 py-1 rounded-lg">Dipinjam</span>
                        @elseif($p->status == 'dikembalikan')
                        <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-lg">Dikembalikan</span>
                        @elseif($p->status == 'ditolak')
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-lg">Ditolak</span>
                        @else
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-lg">Terlambat</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="px-4 py-3">
                        <div class="flex items-center">

                            <!-- KIRI -->
                            <div class="flex items-center gap-3">

                                <!-- DETAIL -->
                                <a href="{{ route('peminjaman.show', $p->id) }}"
                                    class="text-blue-600 hover:underline text-sm">
                                    Detail
                                </a>

                                <!-- KEMBALIKAN -->
                                @if($p->status == 'dipinjam' || $p->status == 'terlambat')
                                <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST">
                                    @csrf
                                    <button class="text-green-600 hover:underline text-sm">
                                        Kembalikan
                                    </button>
                                </form>
                                @endif

                            </div>

                            <!-- KANAN (dorong ke ujung) -->
                            <div class="flex items-center gap-2 ml-auto">

                                <!-- EDIT -->
                                <a href="{{ route('peminjaman.edit', $p->id) }}"
                                    class="bg-blue-50 hover:bg-blue-100 p-2 rounded-lg group"
                                    title="Edit">
                                    <img src="{{ asset('storage/img/edit.png') }}"
                                        class="w-5 h-5 group-hover:scale-110">
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-50 hover:bg-red-100 p-2 rounded-lg group"
                                        title="Hapus">
                                        <img src="{{ asset('storage/img/delete.png') }}"
                                            class="w-5 h-5 group-hover:scale-110">
                                    </button>
                                </form>

                            </div>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-gray-500">
                        Belum ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>
@endsection