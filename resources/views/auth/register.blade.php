<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

    <h2 class="text-xl font-bold text-center mb-6">Register</h2>

    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-600 p-2 rounded text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register" class="space-y-4">
        @csrf

        <div>
            <label class="text-sm text-gray-600">Nama</label>
            <input type="text" name="name"
                class="w-full border rounded-lg px-3 py-2 mt-1 text-sm">
        </div>

        <div>
            <label class="text-sm text-gray-600">Email</label>
            <input type="email" name="email"
                class="w-full border rounded-lg px-3 py-2 mt-1 text-sm">
        </div>

        <div>
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password"
                class="w-full border rounded-lg px-3 py-2 mt-1 text-sm">
        </div>

        <div>
            <label class="text-sm text-gray-600">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full border rounded-lg px-3 py-2 mt-1 text-sm">
        </div>

        <button
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Register
        </button>

        <p class="text-center text-xs text-gray-500 mt-3">
            Sudah punya akun?
            <a href="/login" class="text-blue-600 hover:underline">Login</a>
        </p>

    </form>

</div>

</body>
</html>