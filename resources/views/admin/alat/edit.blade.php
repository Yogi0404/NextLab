@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Alat</h1>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow w-full">

        <form action="{{ route('alat.update', $alat->id) }}" method="POST" 
              enctype="multipart/form-data"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <!-- Kode Alat -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kode Alat</label>
                <input type="text" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                
                @error('kode_alat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Alat -->
            <div>
                <label class="text-sm font-medium text-gray-600">Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                @error('nama_alat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $alat->kategori) }}"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                @error('kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Stok -->
            <div>
                <label class="text-sm font-medium text-gray-600">Total Stok</label>
                <input type="number" name="total_stok" value="{{ old('total_stok', $alat->total_stok) }}"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                @error('total_stok')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kondisi -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kondisi</label>
                <select name="kondisi"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <option value="Baik" {{ old('kondisi', $alat->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ old('kondisi', $alat->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ old('kondisi', $alat->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>

                @error('kondisi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- FOTO -->
            <div>
                <label class="text-sm font-medium text-gray-600">Foto Alat</label>

                <input type="file" name="foto" id="fotoInput"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2">

                <!-- Preview -->
                @if($alat->foto)
                    <img id="previewImage"
                        src="{{ asset('storage/' . $alat->foto) }}"
                        class="mt-3 w-24 h-24 object-cover rounded-lg border">
                @else
                    <img id="previewImage"
                        class="mt-3 w-24 h-24 object-cover rounded-lg border hidden">
                @endif

                @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
            </div>

            <!-- Action -->
            <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">

                <a href="{{ route('alat.index') }}"
                    class="px-5 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 shadow">
                    Update Data
                </button>

            </div>

        </form>

    </div>

</div>

<!-- SCRIPT PREVIEW FOTO -->
<script>
document.getElementById('fotoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>

@endsection