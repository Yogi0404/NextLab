@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah User</h1>
        <p class="text-sm text-gray-500">Tambahkan akun pengguna baru</p>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow w-full">

        <form id="userForm" action="{{ route('user.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Nama -->
            <div>
                <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                <input type="text" name="name" required
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan nama lengkap">
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="contoh@email.com">
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" required minlength="6"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Minimal 6 karakter">
            </div>

            <!-- Role -->
            <div>
                <label class="text-sm font-medium text-gray-600">Role</label>
                <select name="role" required
                    class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="user">User</option>

                </select>
            </div>

            <!-- Action -->
            <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">

                <a href="{{ route('user.index') }}"
                    class="px-5 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition shadow">
                    Simpan User
                </button>

            </div>

        </form>

    </div>

</div>

<!-- POPUP VALIDASI -->
<script>
document.getElementById('userForm').addEventListener('submit', function(e) {

    let kosong = [];

    const fields = [
        {name: 'name', label: 'Nama Lengkap'},
        {name: 'email', label: 'Email'},
        {name: 'password', label: 'Password'},
        {name: 'role', label: 'Role'}
    ];

    fields.forEach(field => {
        const input = document.querySelector(`[name="${field.name}"]`);

        if (!input.value) {
            kosong.push(field.label);
            input.classList.add('border-red-500');
        } else {
            input.classList.remove('border-red-500');
        }
    });

    if (kosong.length > 0) {
        e.preventDefault();

        // gabung field yang kosong
        const pesan = "⚠️ Harus diisi: " + kosong.join(', ');

        const popup = document.createElement('div');
        popup.innerText = pesan;
        popup.className = "fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg";

        document.body.appendChild(popup);

        setTimeout(() => {
            popup.remove();
        }, 3000);
    }
});
</script>

@endsection