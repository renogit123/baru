<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Kemendagri - Selamat Datang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="{{ asset('img/Subtract.png') }}" type="image/png" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #003c8f, #2196f3);
        }

        .fade-in {
            animation: fadeIn 1.2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-white relative">

    <!-- Background Decorative Circles -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute bg-white/10 rounded-full w-96 h-96 top-[-100px] left-[-100px] blur-3xl"></div>
        <div class="absolute bg-white/10 rounded-full w-80 h-80 bottom-[-80px] right-[-80px] blur-2xl"></div>
    </div>

    <!-- Main Content -->
    <div class="z-10 text-center px-6 fade-in">
        <img src="{{ asset('img/Subtract.png') }}" alt="Logo Kemendagri" class="mx-auto w-28 md:w-36 mb-6 drop-shadow-lg">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-sm">
            Selamat Datang di Portal<br><span class="text-yellow-300">Kementerian Dalam Negeri</span>
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Sistem Informasi Manajemen Wilayah. Silakan masuk untuk mulai menggunakan layanan.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('login') }}"
               class="px-6 py-2 rounded-full bg-yellow-400 text-blue-900 font-semibold hover:bg-yellow-300 transition-all shadow-md">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="px-6 py-2 rounded-full border border-white text-white font-semibold hover:bg-white/10 transition-all">
                Daftar
            </a>
        </div>
    </div>
</body>
</html>
