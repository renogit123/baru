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
            background: linear-gradient(to bottom right, #0a1f44, #1e40af);
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .back-link {
            transition: all 0.2s ease-in-out;
        }

        .back-link:hover {
            transform: translateX(-4px);
            color: #facc15; /* Tailwind's yellow-400 */
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.9);
            padding-left: 2.5rem;
        }

        .form-icon {
            left: 0.75rem;
            top: 2.6rem;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 text-white">

    <!-- Tombol Kembali -->
    <a href="{{ url('/') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium shadow hover:bg-yellow-400 hover:text-blue-900 hover:shadow-lg transition duration-300 absolute top-6 left-6 backdrop-blur-sm">
   <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor"
        stroke-width="2" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
   </svg>
   <span class="hidden sm:inline">Kembali ke Beranda</span>
</a>

    <!-- Login Card -->
    <div class="w-full max-w-md p-8 rounded-2xl fade-in card-gradient">
        <div class="text-center mb-6">
            <img src="{{ asset('img/logokemendagri-fix.png') }}" alt="Logo Kemendagri" class="mx-auto w-16 mb-3 drop-shadow-md">
            <h2 class="text-2xl font-bold tracking-wide">Selamat Datang</h2>
            <p class="text-sm text-white/90">Masuk ke portal resmi Kemendagri</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div class="relative">
                <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-10 py-2 rounded-lg form-control text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       placeholder="you@example.com">
                <svg class="w-5 h-5 absolute form-icon text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-.885 1.8l-7.14 5.355a2.25 2.25 0 01-2.64 0L3.885 8.793a2.25 2.25 0 01-.885-1.8V6.75"/>
                </svg>
                @error('email')
                    <span class="text-red-200 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-white mb-1">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-10 py-2 rounded-lg form-control text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       placeholder="••••••••">
                <svg class="w-5 h-5 absolute form-icon text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.5 10.5V7.875a4.5 4.5 0 10-9 0V10.5m-1.875 0h12.75a.375.375 0 01.375.375v8.25a.375.375 0 01-.375.375H4.875a.375.375 0 01-.375-.375v-8.25a.375.375 0 01.375-.375z"/>
                </svg>
                @error('password')
                    <span class="text-red-200 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between text-sm text-white">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    Ingat Saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-yellow-300 hover:underline">Lupa Sandi?</a>
                @endif
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                    class="w-full py-2 bg-yellow-400 text-blue-900 font-semibold rounded-full shadow-md hover:bg-yellow-300 transition duration-200 ease-in-out">
                Masuk
            </button>

            <!-- Link Daftar -->
            <p class="text-sm text-center text-white mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-yellow-300 hover:underline font-semibold">Daftar Sekarang</a>
            </p>
        </form>
    </div>

</body>
</html>
