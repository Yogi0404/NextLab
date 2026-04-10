@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Peminjaman</h1>
        <p class="text-sm text-gray-500">Informasi lengkap peminjaman</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">

        <!-- STATUS BADGE ATAS -->
        <div class="flex justify-between items-start mb-6">

            <div>
                <h2 class="text-lg font-semibold text-gray-700">
                    Detail Transaksi
                </h2>
                <p class="text-xs text-gray-400">
                    ID: #{{ $peminjaman->id }}
                </p>
            </div>

            <!-- STATUS -->
            @switch($peminjaman->status)

                @case('pending')
                    <span class="bg-yellow-100 text-yellow-600 text-xs px-4 py-1.5 rounded-full font-medium">
                        Pending
                    </span>
                @break

                @case('dipinjam')
                    <span class="bg-red-100 text-red-600 text-xs px-4 py-1.5 rounded-full font-medium">
                        Dipinjam
                    </span>
                @break

                @case('dikembalikan')
                    <span class="bg-blue-100 text-blue-600 text-xs px-4 py-1.5 rounded-full font-medium">
                        Dikembalikan
                    </span>
                @break

                @case('request_kembali')
                    <span class="bg-green-100 text-green-600 text-xs px-4 py-1.5 rounded-full font-medium">
                        Request Kembali
                    </span>
                @break

            @endswitch

        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- KIRI -->
            <div class="space-y-4">

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Nama Peminjam</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peminjaman->user->name }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Email</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peminjaman->user->email }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Nama Alat</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peminjaman->alat->nama_alat }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Jumlah</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peminjaman->jumlah }}
                    </p>
                </div>

            </div>

            <!-- KANAN -->
            <div class="space-y-4">

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Tanggal Pinjam</p>
                    <p class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Tanggal Kembali</p>
                    <p class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                    </p>
                </div>

                <!-- INFO TAMBAHAN -->
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <p class="text-xs text-blue-400 mb-1">Informasi</p>
                    <p class="text-sm text-blue-700">
                        Pastikan alat dikembalikan sesuai tanggal untuk menghindari keterlambatan.
                    </p>
                </div>

            </div>

        </div>

        <!-- ACTION -->
        <div class="mt-8 flex justify-end gap-3 border-t pt-5">

            <a href="{{ route('peminjaman.index') }}"
                class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition">
                Kembali
            </a>

            @if($peminjaman->status != 'dikembalikan')
            <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition shadow">
                    Kembalikan
                </button>
            </form>
            @endif

        </div>

    </div>

</div>
@endsection