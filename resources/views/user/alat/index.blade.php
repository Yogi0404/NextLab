@extends('layouts.user')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800 mb-3">
            Daftar Alat
        </h1>

        <div class="relative w-full md:w-80">
            <input type="text" id="searchInput"
                placeholder="Cari alat..."
                class="w-full border pl-10 pr-4 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none shadow-sm">
            <span class="absolute left-3 top-2.5 text-gray-400 text-sm">🔍</span>
        </div>
    </div>

    <!-- GRID -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">

        @foreach($alats as $alat)
        <div class="alat-card bg-white rounded-2xl shadow-sm hover:shadow-xl transition border overflow-hidden">

            <!-- FOTO -->
            <div class="w-full h-36 bg-gray-100">
                @if($alat->foto)
                    <img src="{{ asset('storage/' . $alat->foto) }}"
                        class="w-full h-full object-cover hover:scale-105 transition">
                @endif
            </div>

            <!-- CONTENT -->
            <div class="p-4">

                <h2 class="font-semibold text-sm truncate nama-alat">
                    {{ $alat->nama_alat }}
                </h2>

                <p class="text-xs text-gray-500 mb-3">
                    Stok: {{ $alat->stok_tersedia }}
                </p>

                <div class="flex gap-2">

                    <!-- DETAIL -->
                    <button
                        onclick="openDetailModal(
                            '{{ $alat->nama_alat }}',
                            '{{ $alat->stok_tersedia }}',
                            '{{ $alat->kondisi }}',
                            '{{ $alat->kategori }}',
                            '{{ $alat->deskripsi }}',
                            '{{ $alat->foto ? asset('storage/'.$alat->foto) : '' }}'
                        )"
                        class="w-1/2 bg-gray-200 text-gray-700 py-2 rounded-xl text-xs hover:bg-gray-300">
                        Detail
                    </button>

                    <!-- PINJAM -->
                    <button
                        onclick="openPinjamModal({{ $alat->id }}, '{{ $alat->nama_alat }}')"
                        class="w-1/2 py-2 rounded-xl text-xs text-white
                        {{ $alat->stok_tersedia == 0 ? 'bg-gray-400' : 'bg-blue-600 hover:bg-blue-700' }}"
                        {{ $alat->stok_tersedia == 0 ? 'disabled' : '' }}>
                        Pinjam
                    </button>

                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="detailModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden">

        <!-- FOTO -->
        <div class="w-full h-44 bg-gray-100">
            <img id="detailFoto" class="w-full h-full object-cover">
        </div>

        <div class="p-5">

            <!-- NAMA -->
            <h2 id="detailNama"
                class="text-lg font-semibold text-gray-800 mb-1 leading-snug"></h2>

            <!-- KATEGORI -->
            <p id="detailKategori"
                class="text-xs text-blue-600 font-medium mb-3"></p>

            <!-- INFO -->
            <div class="grid grid-cols-2 gap-3 mb-4">

                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400">Stok</p>
                    <p id="detailStok" class="font-semibold text-gray-800"></p>
                </div>

                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400">Kondisi</p>
                    <p id="detailKondisi" class="font-semibold text-gray-800"></p>
                </div>

            </div>

            <!-- DESKRIPSI -->
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400 mb-1">
                    Deskripsi
                </p>
                <p id="detailDeskripsi"
                    class="text-sm text-gray-700 leading-relaxed max-h-28 overflow-y-auto">
                </p>
            </div>

            <button onclick="closeDetailModal()"
                class="mt-5 w-full py-2.5 rounded-xl text-sm font-medium
                       bg-gray-900 text-white hover:bg-black transition">
                Tutup
            </button>

        </div>

    </div>
</div>

<!-- ================= MODAL PINJAM ================= -->
<div id="pinjamModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl p-6">

        <h2 class="text-lg font-semibold mb-2">Form Peminjaman</h2>
        <p id="namaAlat" class="text-sm text-gray-500 mb-4"></p>

        <form action="{{ url('user/pinjam') }}" method="POST">
            @csrf

            <input type="hidden" name="alat_id" id="alat_id">

            <input type="number" name="jumlah" placeholder="Jumlah"
                class="w-full border rounded-lg px-3 py-2 text-sm mb-2">

            <input type="date" name="tanggal_pinjam"
                class="w-full border rounded-lg px-3 py-2 text-sm mb-2">

            <input type="date" name="tanggal_kembali"
                class="w-full border rounded-lg px-3 py-2 text-sm mb-3">

            <div class="flex gap-2">
                <button type="button" onclick="closePinjamModal()"
                    class="w-1/2 bg-gray-200 py-2 rounded-lg text-sm">
                    Batal
                </button>

                <button class="w-1/2 bg-blue-600 text-white py-2 rounded-lg text-sm">
                    Ajukan
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
function openDetailModal(nama, stok, kondisi, kategori, deskripsi, foto) {
    document.getElementById('detailNama').innerText = nama;
    document.getElementById('detailStok').innerText = stok;
    document.getElementById('detailKondisi').innerText = kondisi || '-';
    document.getElementById('detailKategori').innerText = kategori || '-';
    document.getElementById('detailDeskripsi').innerText = deskripsi || '-';

    if (foto) document.getElementById('detailFoto').src = foto;

    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailModal').classList.add('flex');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('detailModal').classList.remove('flex');
}

function openPinjamModal(id, nama) {
    document.getElementById('alat_id').value = id;
    document.getElementById('namaAlat').innerText = nama;

    document.getElementById('pinjamModal').classList.remove('hidden');
    document.getElementById('pinjamModal').classList.add('flex');
}

function closePinjamModal() {
    document.getElementById('pinjamModal').classList.add('hidden');
    document.getElementById('pinjamModal').classList.remove('flex');
}

// SEARCH
document.getElementById('searchInput').addEventListener('keyup', function() {
    let keyword = this.value.toLowerCase();
    let cards = document.querySelectorAll('.alat-card');

    cards.forEach(card => {
        let nama = card.querySelector('.nama-alat').innerText.toLowerCase();
        card.style.display = nama.includes(keyword) ? 'block' : 'none';
    });
});
</script>

@endsection