<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextLab</title>

    <!-- TAILWIND V2 -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- NAVBAR -->
    <div class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">

        <!-- Logo -->
        <div>
            <h1 class="font-bold text-lg tracking-wide">NEXTLAB</h1>
            <p class="text-xs text-blue-200">Aplikasi Peminjaman</p>
        </div>

        <!-- User -->
        <div class="flex items-center gap-3">

            <div class="text-right">
                <p class="text-sm font-medium">Jihan Sevira</p>
                <p class="text-xs text-blue-200">Admin</p>
            </div>

            <!-- Avatar -->
            <div class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center font-semibold">
                J
            </div>

        </div>

    </div>

    <!-- MENU -->
    <div class="bg-white border-b px-6 py-2 flex gap-6 text-sm overflow-x-auto">

        <a href="/admin"
            class="pb-2 border-b-2 transition
            {{ request()->is('admin')
            ? 'border-blue-700 text-blue-700 font-semibold'
            : 'border-transparent text-gray-500 hover:text-blue-700' }}">
            Dashboard
        </a>

        <a href="/user"
            class="pb-2 border-b-2 transition
            {{ request()->is('user')
            ? 'border-blue-700 text-blue-700 font-semibold'
            : 'border-transparent text-gray-500 hover:text-blue-700' }}">
            User
        </a>

        <a href="/peminjaman"
            class="pb-2 border-b-2 transition
            {{ request()->is('peminjaman')
            ? 'border-blue-700 text-blue-700 font-semibold'
            : 'border-transparent text-gray-500 hover:text-blue-700' }}">
            Peminjaman & Pengembalian
        </a>

        <a href="/denda"
            class="pb-2 border-b-2 transition
            {{ request()->is('denda')
            ? 'border-blue-700 text-blue-700 font-semibold'
            : 'border-transparent text-gray-500 hover:text-blue-700' }}">
            Denda & Pembayaran
        </a>

        <a href="/laporan"
            class="pb-2 border-b-2 transition
            {{ request()->is('laporan')
            ? 'border-blue-700 text-blue-700 font-semibold'
            : 'border-transparent text-gray-500 hover:text-blue-700' }}">
            Laporan
        </a>

        <a href="/alat"
            class="pb-2 border-b-2 transition
            {{ request()->is('alat*')
            ? 'border-blue-700 text-blue-700 font-semibold'
            : 'border-transparent text-gray-500 hover:text-blue-700' }}">
            Daftar Alat
        </a>

        <a href="/logout"
            class="pb-2 border-b-2 transition
            text-red-500 hover:text-red-700">
            Logout
        </a>

    </div>

    <!-- CONTENT -->
    <main class="p-4 md:p-6">

        <!-- NOTIF -->
        @if(session('success'))
        <div id="alert-success"
            class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">

            <span>✅</span>
            <span class="text-sm">{{ session('success') }}</span>

            <button onclick="closeAlert()" class="ml-2">✖</button>
        </div>
        @endif

        @yield('content')

    </main>

    <!-- DELETE MODAL -->
    <div id="deleteModal"
        class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all scale-95 opacity-0" id="modalContent">

            <div class="flex justify-center mb-4">
                <div class="bg-red-100 text-red-600 p-4 rounded-full text-2xl">
                    ⚠️
                </div>
            </div>

            <h2 class="text-lg font-semibold text-center">
                Hapus Data?
            </h2>

            <p class="text-sm text-gray-500 text-center mt-2">
                Data yang dihapus tidak dapat dikembalikan.
            </p>

            <div class="flex justify-center gap-3 mt-6">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Batal
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function closeAlert() {
            const alert = document.getElementById('alert-success');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }
        }

        setTimeout(() => closeAlert(), 3000);

        function openDeleteModal(action) {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('modalContent');
            const form = document.getElementById('deleteForm');

            form.action = action;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }
    </script>

</body>
</html>