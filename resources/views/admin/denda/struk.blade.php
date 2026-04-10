@extends('layouts.app')

@section('content')
<div class="p-4">

    <div id="struk" class="mx-auto bg-white p-4 shadow text-[12px] leading-tight"
        style="width: 300px; font-family: monospace;">

        <!-- HEADER -->
        <div class="text-center mb-2">
            <h2 class="font-bold text-sm tracking-wide">NEXTLAB</h2>
            <p class="text-[10px] text-gray-500">Sistem Peminjaman</p>
            <p class="text-[10px]">
                {{ date('d/m/Y H:i') }}
            </p>
        </div>

        <div class="border-t border-dashed my-2"></div>

        <!-- INFO -->
        <div class="mb-2">
            <div class="flex justify-between">
                <span>No Transaksi</span>
                <span>#{{ $p->id }}</span>
            </div>

            <div class="flex justify-between">
                <span>Nama</span>
                <span class="text-right">{{ $p->user->name }}</span>
            </div>

            <div class="flex justify-between">
                <span>Alat</span>
                <span class="text-right">{{ $p->alat->nama_alat }}</span>
            </div>
        </div>

        <div class="border-t border-dashed my-2"></div>

        <!-- DETAIL -->
        <div class="mb-2 space-y-1">

            <div class="flex justify-between">
                <span>Denda</span>
                <span>Rp {{ number_format($p->denda,0,',','.') }}</span>
            </div>

            <div class="flex justify-between">
                <span>Dibayar</span>
                <span>Rp {{ number_format(session('dibayar'),0,',','.') }}</span>
            </div>

            <div class="flex justify-between font-bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format(session('kembalian'),0,',','.') }}</span>
            </div>

        </div>

        <div class="border-t border-dashed my-2"></div>

        <!-- FOOTER -->
        <div class="text-center mt-2">
            <p class="text-[10px]">Terima kasih 🙏</p>
            <p class="text-[10px]">NEXTLAB SYSTEM</p>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="text-center mt-4 space-x-2">
        <button onclick="printStruk()"
            class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
            🖨️ Cetak
        </button>

        <a href="/denda"
            class="bg-gray-200 px-4 py-2 rounded text-sm hover:bg-gray-300">
            Kembali
        </a>
    </div>

</div>

<!-- PRINT STYLE -->
<style>
@media print {
    body * {
        visibility: hidden;
    }

    #struk, #struk * {
        visibility: visible;
    }

    #struk {
        position: absolute;
        left: 0;
        top: 0;
        width: 300px;
    }
}
</style>

<!-- PRINT SCRIPT -->
<script>
function printStruk() {
    window.print();
}
</script>

@endsection