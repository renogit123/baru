<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kemendagri - Selamat Datang</title>
    <link rel="icon" href="{{ asset('img/logokemendagri-fix.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
        }

        .fade-in {
            animation: fadeIn 1.2s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute inset-0 z-0">
        <div class="absolute bg-blue-400/10 rounded-full w-[500px] h-[500px] top-[-150px] left-[-150px] blur-3xl"></div>
        <div class="absolute bg-yellow-300/10 rounded-full w-[400px] h-[400px] bottom-[-100px] right-[-100px] blur-2xl"></div>
    </div>

    <!-- Main Content -->
    <div class="z-10 text-center px-6 fade-in">
        <img src="{{ asset('img/logokemendagri-fix.png') }}" alt="Logo Kemendagri" class="mx-auto w-28 md:w-36 mb-6 drop-shadow-xl">
        <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
            Selamat Datang di Aplikasi<br>
            <span class="text-yellow-400 drop-shadow">Kementerian Dalam Negeri</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-xl mx-auto">
            Sistem Pendaftaran Pelatihan Balai Besar Bina Pemerintahan dan Desa di Malang,Silahkan Login/Register Terlebih Dahulu
        </p>

        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('login') }}"
               class="px-6 py-2 rounded-full bg-yellow-400 text-blue-900 font-semibold hover:bg-yellow-300 transition-all shadow-md">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="px-6 py-2 rounded-full border border-white/30 text-white hover:bg-white/10 transition-all">
                Daftar
            </a>
        </div>
    </div>
</body>
</html>
