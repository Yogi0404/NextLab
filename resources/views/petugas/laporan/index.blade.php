@extends('layouts.petugas')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <h1 class="text-xl font-semibold mb-4">Laporan Peminjaman</h1>

    <!-- FILTER AUTO -->
    <form method="GET" id="filterForm"
        class="bg-white p-4 rounded-xl shadow mb-4 grid md:grid-cols-4 gap-4">

        <!-- DARI -->
        <div>
            <label class="text-xs text-gray-500">Dari</label>
            <input type="date" name="dari" value="{{ request('dari') }}"
                onchange="autoSubmit()"
                class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <!-- SAMPAI -->
        <div>
            <label class="text-xs text-gray-500">Sampai</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                onchange="autoSubmit()"
                class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <!-- STATUS -->
        <div>
            <label class="text-xs text-gray-500">Status</label>
            <select name="status"
                onchange="autoSubmit()"
                class="w-full border rounded-lg px-3 py-2 text-sm">

                <option value="all">Semua</option>

                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                    Dipinjam
                </option>

                <option value="request_kembali" {{ request('status') == 'request_kembali' ? 'selected' : '' }}>
                    Request
                </option>

                <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>
                    Selesai
                </option>

                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>
                    Terlambat
                </option>

                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                    Ditolak
                </option>

            </select>
        </div>

        <!-- EXPORT -->
        <div class="flex items-end">
            <a href="{{ route('laporan.pdf', request()->all()) }}"
                class="w-full text-center bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition">
                Export PDF
            </a>
        </div>

    </form>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm text-center">

            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">{{ $item->user->name }}</td>

                    <td class="px-4 py-3">{{ $item->alat->nama_alat }}</td>

                    <td class="px-4 py-3 text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        @switch($item->status)

                            @case('pending')
                                <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">Pending</span>
                            @break

                            @case('dipinjam')
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">Dipinjam</span>
                            @break

                            @case('request_kembali')
                                <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded text-xs">Request</span>
                            @break

                            @case('dikembalikan')
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">Selesai</span>
                            @break

                            @case('terlambat')
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">Terlambat</span>
                            @break

                            @case('ditolak')
                                <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">Ditolak</span>
                            @break

                        @endswitch
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-gray-400">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

<!-- AUTO SUBMIT -->
<script>
function autoSubmit() {
    document.getElementById('filterForm').submit();
}
</script>

@endsection