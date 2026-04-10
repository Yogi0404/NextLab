@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Alat</h1>

        <a href="{{ route('alat.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
            + Tambah Alat
        </a>
    </div>

    <!-- Filter & Search -->
    <form method="GET" action="{{ route('alat.index') }}"
        class="bg-white p-4 rounded-xl shadow mb-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">

        <!-- SEARCH -->
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari alat..."
            onkeyup="debounceSubmit()"
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- FILTER -->
        <select name="kategori"
            onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full md:w-1/4">

            <option value="Semua">Semua Kategori</option>
            <option value="Elektronik" {{ request('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
            <option value="ATK" {{ request('kategori') == 'ATK' ? 'selected' : '' }}>ATK</option>
            <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>

        </select>

    </form>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm text-left">

            <!-- Head -->
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Kondisi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="text-gray-700">
                @foreach ($alats as $alat)
                <tr class="border-t hover:bg-gray-50">

                    <!-- FOTO -->
                    <td class="px-4 py-3">
                        @if($alat->foto)
                        <img src="{{ asset('storage/' . $alat->foto) }}"
                            class="w-12 h-12 object-cover rounded-lg border hover:scale-150 transition duration-200">
                        @else
                        <div class="w-12 h-12 flex items-center justify-center bg-gray-100 text-gray-400 text-xs rounded-lg">
                            No Img
                        </div>
                        @endif
                    </td>

                    <td class="px-4 py-3">{{ $alat->kode_alat }}</td>
                    <td class="px-4 py-3">{{ $alat->nama_alat }}</td>
                    <td class="px-4 py-3">{{ $alat->kategori }}</td>

                    <td class="px-4 py-3">
                        {{ $alat->stok_tersedia }} / {{ $alat->total_stok }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-lg">
                            {{ $alat->kondisi }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex justify-center gap-2">

                            <!-- EDIT -->
                            <a href="{{ route('alat.edit', $alat->id) }}"
                                class="bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition group"
                                title="Edit">

                                <img src="{{ asset('storage/img/edit.png') }}"
                                    class="w-5 h-5 object-contain transition duration-200 group-hover:scale-110 group-hover:brightness-75">
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('alat.destroy', $alat->id) }}" method="POST"
                                onsubmit="return confirm('Yakin mau hapus?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-50 hover:bg-red-100 p-2 rounded-lg transition group"
                                    title="Hapus">

                                    <img src="{{ asset('storage/img/delete.png') }}"
                                        class="w-5 h-5 object-contain transition duration-200 group-hover:opacity-70 group-hover:scale-110">
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
@endsection