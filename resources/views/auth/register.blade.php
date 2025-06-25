<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Portal Kemendagri</title>
    <link rel="icon" href="{{ asset('img/Subtract.png') }}" type="image/png" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #1e3a8a, #2563eb); /* Gradasi background */
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-gradient {
            background: linear-gradient(to bottom right, #3b82f6, #60a5fa); /* Gradasi biru terang */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 text-white">

     <!-- Tombol Kembali -->
    <a href="{{ url('/') }}" class="absolute top-6 left-6 text-white text-sm font-semibold flex items-center hover:underline">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Beranda
    </a>

    <!-- Register Card -->
    <div class="w-full max-w-md p-8 rounded-2xl shadow-2xl fade-in card-gradient backdrop-blur-sm">
        <div class="text-center mb-6">
            <img src="{{ asset('img/Subtract.png') }}" alt="Logo Kemendagri" class="mx-auto w-16 mb-3">
            <h2 class="text-2xl font-bold">Pendaftaran Pengguna</h2>
            <p class="text-sm text-white/90">Silakan isi formulir untuk membuat akun Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                @error('name')
                    <span class="text-red-200 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                @error('email')
                    <span class="text-red-200 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                       class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                @error('password')
                    <span class="text-red-200 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-white">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <button type="submit"
                    class="w-full py-2 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">
                Daftar
            </button>

            <p class="text-sm text-center text-white mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-yellow-300 hover:underline">Masuk di sini</a>
            </p>
        </form>
    </div>

</body>
</html>
