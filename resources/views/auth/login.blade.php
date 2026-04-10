<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login NEXTLAB</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- LEFT (FORM) -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-white px-6">

        <div class="w-full max-w-md">

            <!-- Logo -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-blue-900">NEXTLAB</h1>
                <p class="text-sm text-blue-400">Sistem Peminjaman</p>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800">Welcome Back!</h2>
            <p class="text-gray-500 mb-6">Silakan login untuk melanjutkan</p>

            <!-- Alert -->
            @if(session('error'))
                <div class="bg-red-500 text-white text-sm p-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-700 focus:outline-none"
                        placeholder="Masukkan email" required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-700 focus:outline-none"
                        placeholder="Masukkan password" required>
                </div>

                <button
                    class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                    Login
                </button>
            </form>

            <!-- 🔥 TAMBAHAN REGISTER -->
            <p class="text-center text-sm text-gray-500 mt-5">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="text-blue-700 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>

        </div>
    </div>

    <!-- RIGHT (BRANDING) -->
    <div class="hidden md:flex w-1/2 bg-blue-900 text-white items-center justify-center p-10">

        <div class="max-w-md">

            <h2 class="text-3xl font-bold mb-4">
                Sistem Peminjaman NEXTLAB
            </h2>

            <p class="text-blue-200 text-lg">
                "Kelola peminjaman alat dengan lebih cepat, efisien, dan terstruktur."
            </p>

            <p class="mt-4 text-blue-300 text-sm">
                Aplikasi ini membantu admin dalam mengelola data alat,
                peminjaman, pengembalian, serta laporan secara terpusat.
            </p>

            <div class="border-t border-blue-700 my-6"></div>

            <p class="text-xs text-blue-300">
                © 2026 NEXTLAB
            </p>

        </div>

    </div>

</div>

</body>
</html>