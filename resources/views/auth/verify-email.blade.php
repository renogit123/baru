<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Portal Kemendagri</title>
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

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="absolute top-6 left-6">
        @csrf
        <button class="text-white text-sm font-semibold flex items-center hover:underline">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            Logout
        </button>
    </form>

    <!-- Card -->
    <div class="w-full max-w-md p-8 rounded-2xl shadow-2xl fade-in card-gradient backdrop-blur-sm">
        <div class="text-center mb-6">
            <img src="{{ asset('img/Subtract.png') }}" alt="Kemendagri" class="mx-auto w-16 mb-3">
            <h2 class="text-2xl font-bold">Verifikasi Email Anda</h2>
            <p class="text-sm text-white/90 mt-2">
                Terima kasih telah mendaftar. Silakan klik tautan yang kami kirim ke email Anda untuk memverifikasi akun.
                <br>Jika belum menerima email, Anda dapat meminta ulang.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm font-medium text-green-200">
                Tautan verifikasi baru telah dikirim ke email Anda.
            </div>
        @endif

        <div class="mt-4 space-y-4">
            <!-- Kirim ulang -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full py-2 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
        </div>
    </div>

</body>
</html>
