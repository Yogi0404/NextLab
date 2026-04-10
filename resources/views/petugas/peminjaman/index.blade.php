@extends('layouts.petugas')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Peminjaman</h1>

    <!-- TOAST NOTIF -->
    @if(session('success'))
    <div id="toast-success"
        class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50 opacity-0 translate-y-2 transition">
        ✔ <span class="text-sm">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div id="toast-error"
        class="fixed top-5 right-5 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50 opacity-0 translate-y-2 transition">
        ✖ <span class="text-sm">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm text-left">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Alat</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Tanggal Pinjam</th>
                    <th class="px-4 py-3">Tanggal Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjamans as $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">{{ $item->user->name }}</td>
                    <td class="px-4 py-3">{{ $item->alat->nama_alat }}</td>
                    <td class="px-4 py-3">{{ $item->jumlah }}</td>

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3">
                        @if($item->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">Pending</span>
                        @elseif($item->status == 'dipinjam')
                            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">Dipinjam</span>
                        @elseif($item->status == 'dikembalikan')
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">Selesai</span>
                        @elseif($item->status == 'ditolak')
                            <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">Ditolak</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="px-4 py-3 text-center">

                        @if($item->status == 'pending')
                        <div class="flex justify-center gap-2">

                            <button type="button"
                                onclick="openApproveModal('{{ route('peminjaman.approve', $item->id) }}')"
                                class="bg-green-100 text-green-600 px-3 py-1 rounded text-xs hover:bg-green-200">
                                ✔ Approve
                            </button>

                            <button type="button"
                                onclick="openRejectModal('{{ route('peminjaman.reject', $item->id) }}')"
                                class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs hover:bg-red-200">
                                ✖ Tolak
                            </button>

                        </div>
                        @else
                        <span class="text-gray-400 text-xs">Tidak ada aksi</span>
                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Data kosong
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

<!-- MODAL -->
<div id="confirmModal"
    class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div id="modalBox"
        class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 scale-95 opacity-0 transition">

        <div class="text-center">
            <div id="modalIcon" class="text-4xl mb-3">⚠️</div>
            <h2 id="modalTitle" class="text-lg font-semibold mb-2">Konfirmasi</h2>
            <p id="modalText" class="text-sm text-gray-500 mb-5">Yakin?</p>
        </div>

        <div class="flex justify-center gap-3">
            <button onclick="closeModal()"
                class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">
                Batal
            </button>

            <form id="confirmForm" method="POST">
                @csrf
                <button id="confirmBtn"
                    class="px-4 py-2 text-white rounded-lg text-sm">
                    Ya
                </button>
            </form>
        </div>

    </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const showToast = (id) => {
        const el = document.getElementById(id);
        if (!el) return;

        setTimeout(() => {
            el.classList.remove('opacity-0','translate-y-2');
            el.classList.add('opacity-100','translate-y-0');
        },100);

        setTimeout(() => {
            el.classList.remove('opacity-100');
            el.classList.add('opacity-0');
        },3000);
    };

    showToast('toast-success');
    showToast('toast-error');
});

function openApproveModal(action){
    openModal(action,'✔','Setujui Peminjaman?','Stok akan berkurang.','bg-green-600');
}

function openRejectModal(action){
    openModal(action,'✖','Tolak Peminjaman?','Data akan ditolak.','bg-red-600');
}

function openModal(action,icon,title,text,color){
    const modal = document.getElementById('confirmModal');
    const box = document.getElementById('modalBox');

    document.getElementById('confirmForm').action = action;
    document.getElementById('modalIcon').innerHTML = icon;
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalText').innerText = text;

    document.getElementById('confirmBtn').className =
        `px-4 py-2 ${color} text-white rounded-lg text-sm`;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(()=>{
        box.classList.remove('scale-95','opacity-0');
        box.classList.add('scale-100','opacity-100');
    },50);
}

function closeModal(){
    const modal = document.getElementById('confirmModal');
    const box = document.getElementById('modalBox');

    box.classList.remove('scale-100','opacity-100');
    box.classList.add('scale-95','opacity-0');

    setTimeout(()=>{
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    },200);
}
</script>

@endsection