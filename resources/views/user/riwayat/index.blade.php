@extends('layouts.user')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-6">Riwayat Peminjaman</h1>

    <!-- ================= FILTER AUTO ================= -->
    <form method="GET" id="filterForm"
        class="mb-6 grid md:grid-cols-4 gap-4 bg-white p-4 rounded-2xl shadow">

        <!-- FROM -->
        <div>
            <label class="text-xs text-gray-500">Dari</label>
            <input type="date" name="from" value="{{ request('from') }}"
                onchange="autoSubmit()"
                class="w-full border px-3 py-2 rounded-lg text-sm">
        </div>

        <!-- TO -->
        <div>
            <label class="text-xs text-gray-500">Sampai</label>
            <input type="date" name="to" value="{{ request('to') }}"
                onchange="autoSubmit()"
                class="w-full border px-3 py-2 rounded-lg text-sm">
        </div>

        <!-- STATUS -->
        <div>
            <label class="text-xs text-gray-500">Status</label>
            <select name="status"
                onchange="autoSubmit()"
                class="w-full border px-3 py-2 rounded-lg text-sm">

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

                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                    Ditolak
                </option>

            </select>
        </div>

        <!-- EXPORT -->
        <div class="flex items-end">
            <a href="{{ route('user.export.pdf', request()->all()) }}"
                class="w-full text-center bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                Export PDF
            </a>
        </div>

    </form>

    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-2xl shadow overflow-x-auto">

        <table class="w-full text-sm text-center">

            <thead class="bg-gray-50 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Pinjam</th>
                    <th class="px-4 py-3">Kembali</th>
                    <th class="px-4 py-3">Denda</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $item)
                <tr class="border-t hover:bg-gray-50 transition">

                    <td class="px-4 py-3 font-medium">
                        {{ $item->alat->nama_alat }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->jumlah }}
                    </td>

                    <td class="px-4 py-3 text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3 text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    </td>

                    <!-- DENDA -->
                    <td class="px-4 py-3">
                        @if($item->denda_hitung > 0 && in_array($item->status, ['dipinjam','request_kembali']))
                            <div class="flex flex-col items-center">
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-semibold">
                                    Rp {{ number_format($item->denda_hitung,0,',','.') }}
                                </span>
                                <span class="text-[10px] text-gray-400 mt-1">
                                    {{ $item->telat_hari }} hari
                                </span>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>

                    <!-- STATUS -->
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
                            @case('ditolak')
                                <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">Ditolak</span>
                            @break
                        @endswitch
                    </td>

                    <!-- AKSI -->
                    <td class="px-4 py-3">

                        @if($item->denda_hitung > 0 && in_array($item->status, ['dipinjam','request_kembali']))
                            <a href="{{ url('user/bayar/'.$item->id) }}"
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded text-xs">
                                Bayar
                            </a>

                        @elseif($item->status == 'dipinjam')
                            <form action="{{ url('user/kembali/'.$item->id) }}" method="POST">
                                @csrf
                                <button
                                    class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                    Ajukan
                                </button>
                            </form>

                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-gray-500">
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