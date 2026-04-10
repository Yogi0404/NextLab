@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Laporan</h1>
    </div>

    <!-- FILTER -->
    <form id="filterForm" method="GET" action="{{ route('laporan') }}"
        class="bg-white p-4 rounded-xl shadow mb-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">

        <a href="{{ route('laporan.export', request()->all()) }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
            ⬇️ Export PDF
        </a>
        <!-- SEARCH -->
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama / alat..."
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full md:w-1/3 filter-input">

        <!-- DATE -->
        <div class="flex gap-3 w-full md:w-auto">
            <input type="date" name="from" value="{{ request('from') }}"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm filter-input">

            <input type="date" name="to" value="{{ request('to') }}"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm filter-input">
        </div>

        <!-- STATUS -->
        <select name="status"
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full md:w-1/4 filter-input">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam</option>
            <option value="request_kembali" {{ request('status')=='request_kembali'?'selected':'' }}>Request Kembali</option>
            <option value="dikembalikan" {{ request('status')=='dikembalikan'?'selected':'' }}>Selesai</option>
        </select>

    </form>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Keterangan</th>
                    <th class="px-4 py-3 text-center">Status</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @forelse($peminjamans as $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->user->name }}
                    </td>

                    <td class="px-4 py-3">
                        @if(in_array($item->status, ['request_kembali','dikembalikan']))
                        Pengembalian
                        @else
                        Peminjaman
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->alat->nama_alat }}
                    </td>

                    <td class="px-4 py-3">
                        Pinjam {{ $item->jumlah }} unit
                    </td>

                    <td class="px-4 py-3 text-center">
                        @switch($item->status)

                        @case('pending')
                        <span class="bg-yellow-100 text-yellow-600 text-xs px-2 py-1 rounded-lg">Pending</span>
                        @break

                        @case('dipinjam')
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-lg">Dipinjam</span>
                        @break

                        @case('request_kembali')
                        <span class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-lg">Request Kembali</span>
                        @break

                        @case('dikembalikan')
                        <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-lg">Selesai</span>
                        @break

                        @case('ditolak')
                        <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-lg">Ditolak</span>
                        @break

                        @endswitch
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- AUTO FILTER SCRIPT -->
<script>
    const form = document.getElementById('filterForm');
    const inputs = document.querySelectorAll('.filter-input');

    // semua select & date langsung submit
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            form.submit();
        });
    });

    // search kasih delay biar ga spam
    let delay;
    const search = document.querySelector('input[name="search"]');

    search.addEventListener('keyup', function() {
        clearTimeout(delay);
        delay = setTimeout(() => {
            form.submit();
        }, 500);
    });
</script>

@endsection