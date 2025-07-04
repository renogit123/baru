<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password - Kemendagri</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #1e3a8a, #2563eb);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-gradient {
            background: linear-gradient(to bottom right, #3b82f6, #60a5fa);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 text-white relative">

    <!-- Tombol Kembali -->
    <a href="{{ url()->previous() }}" class="absolute top-6 left-6 text-white text-sm font-semibold flex items-center hover:underline">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <!-- Confirm Password Card -->
    <div class="w-full max-w-md p-8 rounded-2xl shadow-2xl fade-in card-gradient backdrop-blur-sm">
        <div class="text-center mb-6">
            <img src="{{ asset('img/logokemendagri-fix.png') }}" alt="Kemendagri" class="mx-auto w-16 mb-3">
            <h2 class="text-2xl font-bold">Konfirmasi Password</h2>
            <p class="text-sm text-white/90">Silakan konfirmasi password Anda untuk melanjutkan.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-200 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                @error('password')
                    <span class="text-red-200 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    class="w-full py-2 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">
                Konfirmasi
            </button>
        </form>
    </div>

</body>
</html>
