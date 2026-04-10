@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">

    <!-- HEADER -->
    <h1 class="text-xl font-semibold text-gray-800 mb-4">Dashboard Admin</h1>

    <div class="grid md:grid-cols-3 gap-4 items-start">

        <!-- LEFT: VERTICAL CARDS -->
        <div class="space-y-3">

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-xs opacity-80">Total User</p>
                    <h2 class="text-xl font-bold">{{ $totalUser }}</h2>
                </div>
                <img src="{{ asset('storage/img/user.png') }}" class="w-6 h-6">
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-xs opacity-80">Total Alat</p>
                    <h2 class="text-xl font-bold">{{ $totalAlat }}</h2>
                </div>
                <img src="{{ asset('storage/img/computer.png') }}" class="w-6 h-6">
            </div>

            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-xs opacity-80">Peminjaman</p>
                    <h2 class="text-xl font-bold">{{ $totalPeminjaman }}</h2>
                </div>
                <img src="{{ asset('storage/img/transfer.png') }}" class="w-6 h-6">
            </div>

            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-xs opacity-80">Belum Kembali</p>
                    <h2 class="text-xl font-bold">{{ $belumKembali }}</h2>
                </div>
                <img src="{{ asset('storage/img/expired.png') }}" class="w-6 h-6">
            </div>

        </div>

        <!-- RIGHT: LINE CHART -->
        <div class="md:col-span-2 bg-white p-4 rounded-lg shadow">

            <div class="mb-2">
                <h2 class="text-sm font-semibold text-gray-700">
                    Grafik Peminjaman per Bulan
                </h2>
                <p class="text-xs text-gray-400">
                    Total peminjaman setiap bulan
                </p>
            </div>

            <div id="main" style="height:300px;"></div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="mt-5 bg-white rounded-lg shadow overflow-hidden">

        <div class="p-3 border-b">
            <h2 class="text-sm font-semibold text-gray-700">Peminjaman Terbaru</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Alat</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2 text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latest as $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-2 font-medium">
                        {{ $item->user->name }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $item->alat->nama_alat }}
                    </td>

                    <td class="px-4 py-2 text-gray-500">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-2 text-center">
                        @switch($item->status)

                        @case('pending')
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-xs">Pending</span>
                        @break

                        @case('dipinjam')
                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">Dipinjam</span>
                        @break

                        @case('dikembalikan')
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">Dikembalikan</span>
                        @break

                        @case('request_kembali')
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">Request</span>
                        @break

                        @endswitch
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">
                        🚫 Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

<!-- ECHART -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

<script>
var chartDom = document.getElementById('main');
var myChart = echarts.init(chartDom);

const months = @json($months);
const data = @json($data);

var option = {
    tooltip: {
        trigger: 'axis'
    },

    xAxis: {
        type: 'category',
        data: months
    },

    yAxis: {
        type: 'value'
    },

    series: [
        {
            name: 'Peminjaman',
            type: 'line',
            smooth: true,
            data: data,
            symbol: 'circle',
            symbolSize: 8,

            lineStyle: {
                width: 3,
                color: '#3B82F6'
            },

            itemStyle: {
                color: '#3B82F6'
            },

            areaStyle: {
                opacity: 0.3,
                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    { offset: 0, color: '#3B82F6' },
                    { offset: 1, color: '#ffffff' }
                ])
            }
        }
    ]
};

myChart.setOption(option);
</script>

@endsection