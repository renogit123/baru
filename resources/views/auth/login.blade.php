<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Kemendagri</title>
    <link rel="icon" href="{{ asset('img/logokemendagri-fix.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #0a1f44, #1e40af); /* Gelap ke biru tua */
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-gradient {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
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

    <!-- Login Card -->
    <div class="w-full max-w-md p-8 rounded-2xl fade-in card-gradient shadow-xl">
        <div class="text-center mb-6">
            <img src="{{ asset('img/logokemendagri-fix.png') }}" alt="Logo Kemendagri" class="mx-auto w-16 mb-3 drop-shadow-md">
            <h2 class="text-2xl font-bold">Selamat Datang</h2>
            <p class="text-sm text-white/90">Masuk ke portal Kemendagri</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
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

            <div class="flex items-center justify-between text-sm text-white mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    Ingat Saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-yellow-300 hover:underline">Lupa Sandi?</a>
                @endif
            </div>

            <button type="submit"
                    class="w-full py-2 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">
                Masuk
            </button>

            <p class="text-sm text-center text-white mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-yellow-300 hover:underline">Daftar Sekarang</a>
            </p>
        </form>
    </div>

</body>
</html>
