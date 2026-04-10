@extends('layouts.user')

@section('content')
<div class="p-4 md:p-6">

    <div class="bg-white p-6 rounded-xl shadow max-w-3xl mx-auto">

        <!-- TITLE -->
        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            Pembayaran Denda
        </h2>

        <!-- ERROR -->
        @if(session('error'))
            <div class="mb-4 bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('peminjaman.prosesBayarUser', $p->id) }}" method="POST">
            @csrf

            <!-- GRID -->
            <div class="grid md:grid-cols-2 gap-4">

                <!-- LEFT -->
                <div>
                    <label class="text-xs text-gray-500">Nama</label>
                    <input type="text"
                        value="{{ $p->user->name }}"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-sm"
                        readonly>
                </div>

                <div>
                    <label class="text-xs text-gray-500">Alat</label>
                    <input type="text"
                        value="{{ $p->alat->nama_alat }}"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-sm"
                        readonly>
                </div>

                <div>
                    <label class="text-xs text-gray-500">Tanggal Kembali</label>
                    <input type="text"
                        value="{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-sm"
                        readonly>
                </div>

                <div>
                    <label class="text-xs text-gray-500">Status</label>
                    <input type="text"
                        value="{{ $p->status }}"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-sm"
                        readonly>
                </div>

            </div>

            <!-- DENDA -->
            <div class="mt-6 border border-gray-200 p-4 rounded-lg bg-gray-50">

                <p class="text-xs text-gray-500 mb-1">
                    Total Denda
                </p>

                <h3 class="text-lg font-semibold text-red-500 tracking-wide">
                    Rp {{ number_format($p->denda_hitung,0,',','.') }}
                </h3>

            </div>

            <!-- INPUT BAYAR -->
            <div class="mt-4">
                <label class="text-xs text-gray-500">Nominal Bayar</label>
                <input type="text" name="nominal" id="nominal"
                    value="{{ number_format($p->denda_hitung,0,',','.') }}"
                    class="w-full border rounded-lg px-3 py-2 mt-1 text-sm"
                    oninput="formatRupiah(this)"
                    required>
            </div>

            <!-- BUTTON -->
            <div class="mt-6 flex justify-end gap-2">

                <a href="/denda"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">
                    Batal
                </a>

                <button
                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                    Bayar
                </button>

            </div>

        </form>

    </div>

</div>

<!-- SCRIPT FORMAT RUPIAH -->
<script>
function formatRupiah(el) {
    let angka = el.value.replace(/[^0-9]/g, '');
    let formatted = new Intl.NumberFormat('id-ID').format(angka);
    el.value = formatted;
}
</script>

@endsection